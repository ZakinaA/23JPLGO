<?php

namespace App\Controller;

use App\Entity\ContratPret;
use App\Entity\Eleve;
use App\Form\ContratPretType;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContratPretController extends AbstractController
{
    public function lister(ManagerRegistry $doctrine)
    {

        $repository = $doctrine->getRepository(ContratPret::class);
        $contratsPret= $repository->findAll();

        return $this->render('contratPret/lister.html.twig', [
            'contratsPret' => $contratsPret,
            ]);

    }

    public function consulter(ManagerRegistry $doctrine, int $id): Response
    {
        $contratPret = $doctrine->getRepository(ContratPret::class)->find($id);

        if (!$contratPret) {
            throw $this->createNotFoundException(
                'Aucun instrument trouvé avec l\'ID '.$id);
        }
        return $this->render('contratPret/consulter.html.twig', [
            'contratPret' => $contratPret,
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
            return $this->redirectToRoute('contratPretLister');
        }

        return $this->render('contratPret/ajouter.html.twig', [ // Change the template path
            'form' => $form->createView(),
        ]);
    }

    public function modifier(Request $request, PersistenceManagerRegistry $doctrine, int $id): Response
    {
        $contratPret = $doctrine->getRepository(ContratPret::class)->find($id);

        if (!$contratPret) {
            throw $this->createNotFoundException('Le contrat de Prêt n\'existe pas');
        }

        $form = $this->createForm(ContratPretType::class, $contratPret);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('contratPretConsulter', ['id' => $contratPret->getId()]);
        }

        return $this->render('contratPret/modifier.html.twig', [
            'form' => $form->createView(),
            'contratPret' => $contratPret,
        ]);
    }


    public function supprimer(ManagerRegistry $doctrine, int $id)
    {
        $entityManager = $doctrine->getManager();
        $contratPret = $entityManager->find(ContratPret::class, $id);

        if (!$contratPret) {
            throw $this->createNotFoundException("Ce contrat n'existe pas");
        }

        $entityManager->remove($contratPret);
        $entityManager->flush();

        return $this->redirectToRoute('contratPretLister');
    }
}