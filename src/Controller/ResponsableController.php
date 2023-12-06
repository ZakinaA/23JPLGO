<?php

namespace App\Controller;

use App\Entity\Responsable;
use App\Form\ResponsableModifierType;
use App\Form\ResponsableType;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ResponsableController extends AbstractController
{
    public function lister(ManagerRegistry $doctrine)
    {

        $repository = $doctrine->getRepository(Responsable::class);
        $responsables= $repository->findAll();

        return $this->render('responsable/lister.html.twig', [
            'responsables' => $responsables,
        ]);

    }

    public function consulter(ManagerRegistry $doctrine, int $id): Response
    {
        $responsable = $doctrine->getRepository(Responsable::class)->find($id);

        if (!$responsable) {
            throw $this->createNotFoundException(
                'Aucun responsable trouvé avec l\'ID '.$id);
        }
        return $this->render('responsable/consulter.html.twig', [
            'responsable' => $responsable,
        ]);
    }

    public function ajouter(Request $request, PersistenceManagerRegistry $doctrine):Response
    {
        $responsable = new responsable();
        $form = $this->createForm(ResponsableType::class, $responsable);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($responsable);
            $entityManager->flush();

            $this->addFlash('success', 'Responsable créé avec succès!'); // Change the flash message
            return $this->redirectToRoute('responsableLister');
        }

        return $this->render('responsable/ajouter.html.twig', [ // Change the template path
            'form' => $form->createView(),
        ]);
    }

    public function modifier(Request $request, PersistenceManagerRegistry $doctrine, int $id): Response
    {
        $responsable = $doctrine->getRepository(Responsable::class)->find($id);

        if (!$responsable) {
            throw $this->createNotFoundException('Le responsable de Prêt n\'existe pas');
        }

        $form = $this->createForm(ResponsableModifierType::class, $responsable);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('responsableConsulter', ['id' => $responsable->getId()]);
        }

        return $this->render('responsable/modifier.html.twig', [
            'form' => $form->createView(),
            'responsable' => $responsable,
        ]);
    }


    public function supprimer(ManagerRegistry $doctrine, int $id)
    {
        $entityManager = $doctrine->getManager();
        $responsable = $entityManager->find(Responsable::class, $id);

        if (!$responsable) {
            throw $this->createNotFoundException("Ce responsable n'existe pas");
        }

        $entityManager->remove($responsable);
        $entityManager->flush();

        return $this->redirectToRoute('responsableLister');
    }
}