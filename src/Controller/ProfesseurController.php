<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Entity\Professeur;
use App\Form\EleveModifierType;
use App\Form\ProfesseurModifierType;
use App\Form\ProfesseurType;
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


class ProfesseurController extends AbstractController
{
    public function consulter(PersistenceManagerRegistry $doctrine, int $id)
    {

        $professeur = $doctrine->getRepository(Professeur::class)->find($id);

        if (!$professeur) {
            throw $this->createNotFoundException(
                'Aucun professeur trouvé avec le numéro ' . $id
            );
        }

        //return new Response('Professeur : '.$professeur->getNom());
        return $this->render('professeur/consulter.html.twig', [
            'professeur' => $professeur,]);
    }


    public function lister(PersistenceManagerRegistry $doctrine)
    {

        $repository = $doctrine->getRepository(Professeur::class);

        $professeur = $repository->findAll();
        return $this->render('professeur/lister.html.twig', [
            'pProfesseur' => $professeur,]);
    }


    public function ajouter(Request $request, PersistenceManagerRegistry $doctrine): Response
    {
        $professeur = new professeur();
        $form = $this->createForm(ProfesseurType::class, $professeur);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($professeur);
            $entityManager->flush();

            $this->addFlash('success', 'Professeur created successfully!');
            return $this->redirectToRoute('professeurLister');
        }

        return $this->render('professeur/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    public function modifier(Request $request, PersistenceManagerRegistry $doctrine, int $id): Response
    {

        $professeur = $doctrine->getRepository(Professeur::class)->find($id);


        if (!$professeur) {
            throw $this->createNotFoundException('Le professeur n\'existe pas');
        }

        $form = $this->createForm(ProfesseurModifierType::class, $professeur);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('professeurConsulter', ['id' => $professeur->getId()]);
        }

        return $this->render('professeur/modifier.html.twig', [
            'form' => $form->createView(),
            'professeur' => $professeur,
        ]);
    }

    
    public function supprimer(PersistenceManagerRegistry $doctrine, int $id)
    {
        $entityManager = $doctrine->getManager();
        $professeur = $entityManager->find(Professeur::class, $id);

        if (!$professeur) {
            throw $this->createNotFoundException("Pas de professeur avec cet ID !");
        }

        $entityManager->remove($professeur);
        $entityManager->flush();

        return $this->redirectToRoute('professeurLister');
    }

}
