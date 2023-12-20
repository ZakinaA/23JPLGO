<?php

namespace App\Controller;

use App\Entity\ClasseInstrument;
use App\Form\ClasseInstrumentType;
use App\Form\ClasseInstrumentModifierType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClasseInstrumentController extends AbstractController
{
    #[Route('/classe-instrument', name: 'app_classe_instrument')]
    public function index(): Response
    {
        return $this->render('classe_instrument/index.html.twig', [
            'controller_name' => 'ClasseInstrumentController',
        ]);
    }

    /**
     * @Route("/classe-instrument/lister", name="classeInstrumentLister")
     */
    public function lister(Request $request, ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(ClasseInstrument::class);
        $classesInstruments = $repository->findAll();

        return $this->render('classe_instrument/lister.html.twig', [
            'classesInstruments' => $classesInstruments,
        ]);
    }

    /**
     * @Route("/classe-instrument/consulter/{id}", name="classeInstrumentConsulter")
     */
    public function consulter(ManagerRegistry $doctrine, int $id): Response
    {
        $classeInstrument = $doctrine->getRepository(ClasseInstrument::class)->find($id);

        if (!$classeInstrument) {
            throw $this->createNotFoundException('Classe d\'instrument non trouvée.');
        }

        return $this->render('classe_instrument/consulter.html.twig', [
            'classeInstrument' => $classeInstrument,
        ]);
    }

    /**
     * @Route("/classe-instrument/ajouter", name="classeInstrumentAjouter")
     */
    public function ajouter(Request $request, ManagerRegistry $doctrine): Response
    {
        $classeInstrument = new ClasseInstrument();
        $form = $this->createForm(ClasseInstrumentType::class, $classeInstrument);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($classeInstrument);
            $entityManager->flush();

            $this->addFlash('success', 'Classe d\'instrument ajoutée avec succès !');
            return $this->redirectToRoute('classeInstrumentLister');
        }

        return $this->render('classe_instrument/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/classe-instrument/modifier/{id}", name="classeInstrumentModifier")
     */
    public function modifier(Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        $classeInstrument = $doctrine->getRepository(ClasseInstrument::class)->find($id);

        if (!$classeInstrument) {
            throw $this->createNotFoundException('Classe d\'instrument non trouvée.');
        }

        $form = $this->createForm(ClasseInstrumentType::class, $classeInstrument);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->flush();

            $this->addFlash('success', 'Classe d\'instrument mise à jour avec succès !');
            return $this->redirectToRoute('classeInstrumentConsulter', ['id' => $classeInstrument->getId()]);
        }

        return $this->render('classe_instrument/modifier.html.twig', [
            'form' => $form->createView(),
            'classeInstrument' => $classeInstrument,
        ]);
    }

    /**
     * @Route("/classe-instrument/supprimer/{id}", name="classeInstrumentSupprimer")
     */
    public function supprimer(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $classeInstrument = $entityManager->getRepository(ClasseInstrument::class)->find($id);

        if (!$classeInstrument) {
            throw $this->createNotFoundException('Classe d\'instrument non trouvée.');
        }

        $entityManager->remove($classeInstrument);
        $entityManager->flush();

        $this->addFlash('success', 'Classe d\'instrument supprimée avec succès !');

        return $this->redirectToRoute('classeInstrumentLister');
    }
}
