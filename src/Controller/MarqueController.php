<?php

namespace App\Controller;

use App\Entity\Instrument;
use App\Entity\Marque;
use App\Form\MarqueModifierType;
use App\Form\MarqueType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MarqueController extends AbstractController
{
    /**
     * @Route("/marque/lister", name="marqueLister")
     */
    public function lister(Request $request, ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Marque::class);
        $marques = $repository->findAll();

        return $this->render('marque/lister.html.twig', [
            'marques' => $marques,
        ]);
    }

    /**
     * @Route("/marque/consulter/{id}", name="marqueConsulter")
     */
    public function consulter(ManagerRegistry $doctrine, int $id): Response
    {
        $marque = $doctrine->getRepository(Marque::class)->find($id);

        if (!$marque) {
            throw $this->createNotFoundException('Marque non trouvée.');
        }

        // Utilise une requête personnalisée pour récupérer les instruments liés à la marque
        $instruments = $doctrine->getRepository(Instrument::class)->findByMarque($marque);

        return $this->render('marque/consulter.html.twig', [
            'marque' => $marque,
            'instruments' => $instruments,
        ]);
    }

    /**
     * @Route("/marque/ajouter", name="marqueAjouter")
     */
    public function ajouter(Request $request, ManagerRegistry $doctrine): Response
    {
        $marque = new Marque();
        $form = $this->createForm(MarqueType::class, $marque);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($marque);
            $entityManager->flush();

            $this->addFlash('success', 'Marque ajoutée avec succès !');
            return $this->redirectToRoute('marqueLister');
        }

        return $this->render('marque/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/marque/modifier/{id}", name="marqueModifier")
     */
    public function modifier(Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        $marque = $doctrine->getRepository(Marque::class)->find($id);

        if (!$marque) {
            throw $this->createNotFoundException('Marque non trouvée.');
        }

        $form = $this->createForm(MarqueModifierType::class, $marque);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->flush();

            $this->addFlash('success', 'Marque mise à jour avec succès !');
            return $this->redirectToRoute('marqueConsulter', ['id' => $marque->getId()]);
        }

        return $this->render('marque/modifier.html.twig', [
            'form' => $form->createView(),
            'marque' => $marque,
        ]);
    }

    /**
     * @Route("/marque/supprimer/{id}", name="marqueSupprimer")
     */
    public function supprimer(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $marque = $entityManager->getRepository(Marque::class)->find($id);

        if (!$marque) {
            throw $this->createNotFoundException('Marque non trouvée.');
        }

        $entityManager->remove($marque);
        $entityManager->flush();

        $this->addFlash('success', 'Marque supprimée avec succès !');

        return $this->redirectToRoute('marqueLister');
    }
}
