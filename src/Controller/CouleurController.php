<?php

namespace App\Controller;

use App\Entity\Couleur;
use App\Form\CouleurModifierType;
use App\Form\CouleurType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CouleurController extends AbstractController
{
    #[Route('/couleur', name: 'app_couleur')]
    public function index(): Response
    {
        return $this->render('couleur/index.html.twig', [
            'controller_name' => 'CouleurController',
        ]);
    }

    /**
     * @Route("/couleur/lister", name="couleurLister")
     */
    public function lister(Request $request, ManagerRegistry $doctrine): Response
    {
        $searchTerm = $request->query->get('search');
        $sortField = $request->query->get('sort', 'nom');
        $sortOrder = $request->query->get('order', 'asc');

        $repository = $doctrine->getRepository(Couleur::class);
        $queryBuilder = $repository->createQueryBuilder('c');

        // Add search condition if a search term is provided
        if ($searchTerm) {
            $queryBuilder
                ->andWhere('c.nom LIKE :searchTerm')
                ->setParameter('searchTerm', '%' . $searchTerm . '%');
        }

        // Add sorting
        $queryBuilder->orderBy("c.{$sortField}", $sortOrder);

        $couleurs = $queryBuilder->getQuery()->getResult();

        return $this->render('couleur/lister.html.twig', [
            'couleurs' => $couleurs,
            'sortField' => $sortField,
            'sortOrder' => $sortOrder,
        ]);
    }

    public function consulter(ManagerRegistry $doctrine, int $id)
    {
        $couleur = $doctrine->getRepository(Couleur::class)->find($id);

        if (!$couleur) {
            throw $this->createNotFoundException(
                'Aucune couleur trouvée avec l\'ID ' . $id
            );
        }

        return $this->render('couleur/consulter.html.twig', [
            'couleur' => $couleur,
        ]);
    }

    public function ajouter(Request $request, ManagerRegistry $doctrine): Response
    {
        $couleur = new Couleur();
        $form = $this->createForm(CouleurType::class, $couleur);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($couleur);
            $entityManager->flush();

            $this->addFlash('success', 'Couleur ajoutée avec succès !');
            return $this->redirectToRoute('couleurLister');
        }

        return $this->render('couleur/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/couleur/modifier/{id}", name="couleurModifier")
     */
    public function modifier(Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        $couleur = $doctrine->getRepository(Couleur::class)->find($id);

        if (!$couleur) {
            throw $this->createNotFoundException('Couleur non trouvée.');
        }

        $form = $this->createForm(CouleurModifierType::class, $couleur);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->flush();

            $this->addFlash('success', 'Couleur mise à jour avec succès !');
            return $this->redirectToRoute('couleurConsulter', ['id' => $couleur->getId()]);
        }

        return $this->render('couleur/modifier.html.twig', [
            'form' => $form->createView(),
            'couleur' => $couleur,
        ]);
    }

    /**
     * @Route("/couleur/supprimer/{id}", name="couleurSupprimer")
     */
    public function supprimer(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $couleur = $entityManager->getRepository(Couleur::class)->find($id);

        if (!$couleur) {
            throw $this->createNotFoundException('Couleur non trouvée.');
        }

        // Remove the color
        $entityManager->remove($couleur);
        $entityManager->flush();

        $this->addFlash('success', 'Couleur supprimée avec succès !');

        return $this->redirectToRoute('couleurLister');
    }
}