<?php

namespace App\Controller;


// Import the necessary classes at the top of your controller
use App\Entity\Instrument;
use App\Form\InstrumentModifierType;
use App\Form\InstrumentType; // Make sure to adjust the namespace based on your project structure
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;


class InstrumentController extends AbstractController
{
    #[Route('/instrument', name: 'app_instrument')]
    public function index(): Response
    {
        return $this->render('instrument/index.html.twig', [
            'controller_name' => 'InstrumentController',
        ]);
    }

    public function lister(ManagerRegistry $doctrine)
    {

        $repository = $doctrine->getRepository(Instrument::class);

        $instruments = $repository->findAll();
        return $this->render('instrument/lister.html.twig', [
            'pInstruments' => $instruments,]);

    }


    public function consulter(ManagerRegistry $doctrine, int $id)
    {
        $instrument = $doctrine->getRepository(Instrument::class)->find($id);

        if (!$instrument) {
            throw $this->createNotFoundException(
                'Aucun instrument trouvé avec l\'ID ' . $id
            );
        }
        return $this->render('instrument/consulter.html.twig', [
            'instrument' => $instrument,
        ]);
    }


    public function ajouter(Request $request, PersistenceManagerRegistry $doctrine):Response
    {
        $instrument = new instrument();
        $form = $this->createForm(InstrumentType::class, $instrument);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($instrument);
            $entityManager->flush();

            $this->addFlash('success', 'Instrument created successfully!'); // Change the flash message
            return $this->redirectToRoute('instrumentLister');
        }

        return $this->render('instrument/ajouter.html.twig', [ // Change the template path
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/instrument/modifier/{id}", name="edit_instrument")
     */
    public function modifier(Request $request, PersistenceManagerRegistry $doctrine, Instrument $instrument): Response
    {
        // Utilisez le nouveau formulaire de modification
        $form = $this->createForm(InstrumentModifierType::class, $instrument);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->flush();

            $this->addFlash('success', 'Instrument mis à jour avec succès !');
            return $this->redirectToRoute('view_instrument', ['id' => $instrument->getId()]);
        }

        return $this->render('instrument/edit.html.twig', [
            'form' => $form->createView(),
            'instrument' => $instrument,
        ]);
    }


    }
