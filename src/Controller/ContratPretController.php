<?php

namespace App\Controller;

use App\Entity\ContratPret;
use App\Entity\Eleve;
use App\Entity\Etudiant;
use App\Form\ContratPretType;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContratPretController extends AbstractController
{
    #[Route('/contratPrets', name: 'app_contratPret')]
    public function index(): Response
    {
        return $this->render('contratPret/index.html.twig', [
            'controller_name' => 'InstrumentController',
        ]);
    }

    public function lister(ManagerRegistry $doctrine)
    {

        $repository = $doctrine->getRepository(ContratPret::class);
        $contratsPret= $repository->findAll();

        $repository = $doctrine->getRepository(Eleve::class);
        $eleves= $repository->findAll();

        return $this->render('contratPret/lister.html.twig', [
            'pContratsPret' => $contratsPret,
            'pEleves' => $eleves,
            ]);

    }

    public function consulter(ManagerRegistry $doctrine, int $id)
    {
        $contratsPret = $doctrine->getRepository(ContratPret::class)->find($id);

        if (!$contratsPret) {
            throw $this->createNotFoundException(
                'Aucun instrument trouvé avec l\'ID '.$id
            );
        }
        return $this->render('contratPret/consulter.html.twig', [
            'pContratsPret' => $contratsPret,
        ]);
    }

    //#[Route('/contratPret/ajouter', name: 'ajouter')]
    public function ajouter(Request $request, PersistenceManagerRegistry $doctrine):Response
    {
        $contratPret = new contratPret();
        $form = $this->createForm(ContratPretType::class, $contratPret);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($contratPret);
            $entityManager->flush();

            $this->addFlash('success', 'ContratPret créé avec succès!'); // Change the flash message
            return $this->redirectToRoute('app_contratPretAjouter');
        }

        return $this->render('contratPret/ajouter.html.twig', [ // Change the template path
            'form' => $form->createView(),
        ]);
    }
}