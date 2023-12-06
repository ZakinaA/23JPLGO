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

    #[Route('/instrument/lister', name: 'instrumentLister')]
    public function lister(Request $request, ManagerRegistry $doctrine): Response
    {
        $searchTerm = $request->query->get('search');
        $repository = $doctrine->getRepository(Instrument::class);

        // Use a custom repository method to handle the search logic
        if ($searchTerm !== null) {
            $instruments = $repository->findBySearchTerm($searchTerm);
        } else {
            // If $searchTerm is null, fetch all instruments (or handle it as needed)
            $instruments = $repository->findAll();
        }

        return $this->render('instrument/lister.html.twig', [
            'pInstruments' => $instruments,
        ]);
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
     * @Route("/instrument/modifier/{id}", name="instrumentModifier")
     */
    public function modifier(Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        $instrument = $doctrine->getRepository(Instrument::class)->find($id);

        if (!$instrument) {
            throw $this->createNotFoundException('Instrument not found.');
        }

        $form = $this->createForm(InstrumentModifierType::class, $instrument);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->flush();

            $this->addFlash('success', 'Instrument mis à jour avec succès !');
            return $this->redirectToRoute('instrumentConsulter', ['id' => $instrument->getId()]);
        }

        return $this->render('instrument/modifier.html.twig', [
            'form' => $form->createView(),
            'instrument' => $instrument,
        ]);
    }
    /**
     * @Route("/instrument/supprimer/{id}", name="instrumentSupprimer")
     */
    public function supprimer(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $instrument = $entityManager->getRepository(Instrument::class)->find($id);

        if (!$instrument) {
            throw $this->createNotFoundException('Instrument not found.');
        }

        // Remove the instrument
        $entityManager->remove($instrument);
        $entityManager->flush();

        // Add a flash message to indicate successful deletion
        $this->addFlash('success', 'Instrument supprimé avec succès !');

        // Redirect to the list page or any other route
        return $this->redirectToRoute('instrumentLister');
    }

    public function findBySearchTerm(string $searchTerm)
    {
        // Customize this method based on your entity associations
        $queryBuilder = $this->createQueryBuilder('i')
            ->leftJoin('i.marque', 'm')
            ->leftJoin('i.TypeInstrument', 't')
            ->leftJoin('t.ClasseInstrument', 'c')
            ->where('i.numSerie LIKE :searchTerm')
            ->orWhere('m.libelle LIKE :searchTerm')
            ->orWhere('t.libelle LIKE :searchTerm')
            ->orWhere('c.libelle LIKE :searchTerm')
            ->setParameter('searchTerm', '%'.$searchTerm.'%');

        return $queryBuilder->getQuery()->getResult();
    }
}
