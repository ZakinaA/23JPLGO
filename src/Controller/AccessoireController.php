<?php

namespace App\Controller;

use App\Entity\Accessoire;

use App\Form\AccessoireModifierType;
use App\Form\AccessoireType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccessoireController extends AbstractController
{
    #[Route('/accessoire', name: 'app_accessoire')]
    public function index(): Response
    {
        return $this->render('accessoire/index.html.twig', [
            'controller_name' => 'AccessoireController',
        ]);
    }

    /**
     * @Route("/accessoire/lister", name="accessoireLister")
     */
    public function lister(Request $request, ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Accessoire::class);
        $accessoires = $repository->findAll();

        return $this->render('accessoire/lister.html.twig', [
            'accessoires' => $accessoires,
        ]);
    }

    /**
     * @Route("/accessoire/consulter/{id}", name="accessoireConsulter")
     */
    public function consulter(ManagerRegistry $doctrine, int $id): Response
    {
        $accessoire = $doctrine->getRepository(Accessoire::class)->find($id);

        if (!$accessoire) {
            throw $this->createNotFoundException('Accessoire non trouvé.');
        }

        return $this->render('accessoire/consulter.html.twig', [
            'accessoire' => $accessoire,
        ]);
    }

    /**
     * @Route("/accessoire/ajouter", name="accessoireAjouter")
     */
    public function ajouter(Request $request, ManagerRegistry $doctrine): Response
    {
        $accessoire = new Accessoire();
        $form = $this->createForm(AccessoireType::class, $accessoire);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($accessoire);
            $entityManager->flush();

            $this->addFlash('success', 'Accessoire ajouté avec succès !');
            return $this->redirectToRoute('accessoireLister');
        }

        return $this->render('accessoire/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/accessoire/modifier/{id}", name="accessoireModifier")
     */
    public function modifier(Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        $accessoire = $doctrine->getRepository(Accessoire::class)->find($id);

        if (!$accessoire) {
            throw $this->createNotFoundException('Accessoire non trouvé.');
        }

        $form = $this->createForm(AccessoireType::class, $accessoire);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->flush();

            $this->addFlash('success', 'Accessoire mis à jour avec succès !');
            return $this->redirectToRoute('accessoireConsulter', ['id' => $accessoire->getId()]);
        }

        return $this->render('accessoire/modifier.html.twig', [
            'form' => $form->createView(),
            'accessoire' => $accessoire,
        ]);
    }

    /**
     * @Route("/accessoire/supprimer/{id}", name="accessoireSupprimer")
     */
    public function supprimer(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $accessoire = $entityManager->getRepository(Accessoire::class)->find($id);

        if (!$accessoire) {
            throw $this->createNotFoundException('Accessoire non trouvé.');
        }

        $entityManager->remove($accessoire);
        $entityManager->flush();

        $this->addFlash('success', 'Accessoire supprimé avec succès !');

        return $this->redirectToRoute('accessoireLister');
    }
}