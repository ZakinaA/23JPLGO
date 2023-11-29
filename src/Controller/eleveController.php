<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Form\EleveModifierType;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Cours;
use App\Form\EleveType;
use App\Entity\Task;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;


class eleveController extends AbstractController
{
    public function consulter(PersistenceManagerRegistry $doctrine, int $id)
    {

        $eleve = $doctrine->getRepository(Eleve::class)->find($id);

        if (!$eleve) {
            throw $this->createNotFoundException(
                'Aucun cours trouvé avec le numéro ' . $id
            );
        }

        //return new Response('Eleve : '.$eleve->getLibelle());
        return $this->render('eleve/consulter.html.twig', [
            'eleve' => $eleve,]);
    }


    public function lister(PersistenceManagerRegistry $doctrine)
    {

        $repository = $doctrine->getRepository(Eleve::class);

        $eleve = $repository->findAll();
        return $this->render('eleve/lister.html.twig', [
            'pEleve' => $eleve,]);
    }


    public function ajouter(Request $request, PersistenceManagerRegistry $doctrine): Response
    {
        $eleve = new eleve();
        $form = $this->createForm(EleveType::class, $eleve);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($eleve);
            $entityManager->flush();

            $this->addFlash('success', 'Eleve created successfully!');
            return $this->redirectToRoute('eleveLister');
        }

        return $this->render('eleve/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function ajouterCours(){

        $eleve = new eleve();
        $form = $this->createForm(Cours::class, $eleve);
        return $this->render('eleve/ajouter.html.twig', array(
            'form' => $form->createView(), ));
    }

    public function modifier(Request $request, PersistenceManagerRegistry $doctrine, int $id): Response
    {
        // Récupérer l'eleve depuis la base de données
        $eleve = $doctrine->getRepository(Eleve::class)->find($id);

        // Vérifier si le cours existe
        if (!$eleve) {
            throw $this->createNotFoundException('L\'élève n\'existe pas');
        }

        // Créer le formulaire en utilisant l'objet récupéré depuis la base de données
        $form = $this->createForm(EleveModifierType::class, $eleve);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('eleveModifier', ['id' => $eleve->getId()]);
        }

        return $this->render('eleve/ajouter.html.twig', [
            'form' => $form->createView(),
            'eleve' => $eleve,
        ]);
    }

    
    public function supprimer(PersistenceManagerRegistry $doctrine, int $id)
    {
        $entityManager = $doctrine->getManager();
        $eleve = $entityManager->find(Eleve::class, $id);

        if (!$eleve) {
            throw $this->createNotFoundException("Pas d'élève avec et ID !");
        }

        $entityManager->remove($eleve);
        $entityManager->flush();

        return $this->redirectToRoute('eleveLister');
    }
}
