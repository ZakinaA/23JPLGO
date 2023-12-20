<?php

namespace App\Controller;

use App\Entity\TypeInstrument;
use App\Form\TypeInstrumentModifierType;
use App\Form\TypeInstrumentType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TypeInstrumentController extends AbstractController
{
    #[Route('/type_instrument', name: 'app_type_instrument')]
    public function index(): Response
    {
        return $this->render('type_instrument/index.html.twig', [
            'controller_name' => 'TypeInstrumentController',
        ]);
    }

    /**
     * @Route("/type_instrument/lister", name="typeInstrumentLister")
     */
    public function lister(Request $request, ManagerRegistry $doctrine): Response
    {
        $searchTerm = $request->query->get('search');
        $sortField = $request->query->get('sort', 'libelle');
        $sortOrder = $request->query->get('order', 'asc');

        $repository = $doctrine->getRepository(TypeInstrument::class);
        $queryBuilder = $repository->createQueryBuilder('ti');

        // Add search condition if a search term is provided
        if ($searchTerm) {
            $queryBuilder
                ->andWhere('ti.libelle LIKE :searchTerm')
                ->setParameter('searchTerm', '%' . $searchTerm . '%');
        }

        // Add sorting
        $queryBuilder->orderBy("ti.{$sortField}", $sortOrder);

        $typesInstruments = $queryBuilder->getQuery()->getResult();

        return $this->render('type_instrument/lister.html.twig', [
            'typesInstruments' => $typesInstruments,
            'sortField' => $sortField,
            'sortOrder' => $sortOrder,
        ]);
    }

    public function consulter(ManagerRegistry $doctrine, int $id)
    {
        $typeInstrument = $doctrine->getRepository(TypeInstrument::class)->find($id);

        if (!$typeInstrument) {
            throw $this->createNotFoundException(
                'Aucun type d\'instrument trouvé avec l\'ID ' . $id
            );
        }

        return $this->render('type_instrument/consulter.html.twig', [
            'typeInstrument' => $typeInstrument,
        ]);
    }

    public function ajouter(Request $request, ManagerRegistry $doctrine): Response
    {
        $typeInstrument = new TypeInstrument();
        $form = $this->createForm(TypeInstrumentType::class, $typeInstrument);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($typeInstrument);
            $entityManager->flush();

            $this->addFlash('success', 'Type d\'instrument ajouté avec succès !');
            return $this->redirectToRoute('typeInstrumentLister');
        }

        return $this->render('type_instrument/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/type_instrument/modifier/{id}", name="typeInstrumentModifier")
     */
    public function modifier(Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        $typeInstrument = $doctrine->getRepository(TypeInstrument::class)->find($id);

        if (!$typeInstrument) {
            throw $this->createNotFoundException('Type d\'instrument non trouvé.');
        }

        $form = $this->createForm(TypeInstrumentModifierType::class, $typeInstrument);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->flush();

            $this->addFlash('success', 'Type d\'instrument mis à jour avec succès !');
            return $this->redirectToRoute('typeInstrumentConsulter', ['id' => $typeInstrument->getId()]);
        }

        return $this->render('type_instrument/modifier.html.twig', [
            'form' => $form->createView(),
            'typeInstrument' => $typeInstrument,
        ]);
    }

    /**
     * @Route("/type_instrument/supprimer/{id}", name="typeInstrumentSupprimer")
     */
    public function supprimer(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $typeInstrument = $entityManager->getRepository(TypeInstrument::class)->find($id);

        if (!$typeInstrument) {
            throw $this->createNotFoundException('Type d\'instrument non trouvé.');
        }

        // Remove the type of instrument
        $entityManager->remove($typeInstrument);
        $entityManager->flush();

        $this->addFlash('success', 'Type d\'instrument supprimé avec succès !');

        return $this->redirectToRoute('typeInstrumentLister');
    }

}