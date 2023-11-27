<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Form\CoursModifierType;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Cours;
use App\Entity\Maison;
use App\Form\CoursType;
use App\Entity\Task;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;


class coursController extends AbstractController
{
    public function consulter(ManagerRegistry $doctrine, int $id)
    {

        $cours = $doctrine->getRepository(Cours::class)->find($id);

        if (!$cours) {
            throw $this->createNotFoundException(
                'Aucun cours trouvé avec le numéro ' . $id
            );
        }

        //return new Response('Cours : '.$cours->getLibelle());
        return $this->render('cours/consulter.html.twig', [
            'cours' => $cours,]);
    }


    public function lister(ManagerRegistry $doctrine)
    {

        $repository = $doctrine->getRepository(Cours::class);

        $cours = $repository->findAll();
        return $this->render('cours/lister.html.twig', [
            'pCours' => $cours,]);
    }


    public function ajouter(Request $request, PersistenceManagerRegistry $doctrine): Response
    {
        $cours = new cours();
        $form = $this->createForm(CoursType::class, $cours);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($cours);
            $entityManager->flush();

            $this->addFlash('success', 'Cours created successfully!');
            return $this->redirectToRoute('coursLister');
        }

        return $this->render('cours/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function ajouterCours(){

        $cours = new cours();
        $form = $this->createForm(Cours::class, $cours);
        return $this->render('cours/ajouter.html.twig', array(
            'form' => $form->createView(), ));
    }

    public function modifier(Request $request, PersistenceManagerRegistry $doctrine, int $id): Response
    {
        // Récupérer le cours depuis la base de données
        $cours = $doctrine->getRepository(Cours::class)->find($id);

        // Vérifier si le cours existe
        if (!$cours) {
            throw $this->createNotFoundException('Le cours n\'existe pas');
        }

        // Créer le formulaire en utilisant l'objet récupéré depuis la base de données
        $form = $this->createForm(CoursModifierType::class, $cours);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('coursModifier', ['id' => $cours->getId()]);
        }

        return $this->render('cours/ajouter.html.twig', [
            'form' => $form->createView(),
            'cours' => $cours,
        ]);
    }

    
    public function supprimer(ManagerRegistry $doctrine, int $id)
    {
        $entityManager = $doctrine->getManager();
        $cours = $entityManager->find(Cours::class, $id);

        if (!$cours) {
            throw $this->createNotFoundException("Pas de cours avec et ID !");
        }

        $entityManager->remove($cours);
        $entityManager->flush();

        return $this->redirectToRoute('coursLister');
    }
}
