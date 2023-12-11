<?php

// src/Controller/InscriptionController.php

namespace App\Controller;

use App\Entity\Cours;
use App\Entity\Eleve;
use App\Entity\Inscription;
use App\Form\EleveModifierType;
use App\Form\EleveType;
use App\Form\InscriptionModifierType;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/inscription/{idCours}/{idEleve}", name="inscription_eleve_cours")
     */


    public function consulter(PersistenceManagerRegistry $doctrine, int $id)
    {

        $inscription = $doctrine->getRepository(Inscription::class)->find($id);

        if (!$inscription) {
            throw $this->createNotFoundException(
                'Aucune inscription trouvée avec le numéro ' . $id
            );
        }


        return $this->render('inscription/consulter.html.twig', [
            'inscription' => $inscription,]);
    }

    public function lister(PersistenceManagerRegistry $doctrine)
    {

        $repository = $doctrine->getRepository(Inscription::class);

        $inscription = $repository->findAll();
        return $this->render('inscription/lister.html.twig', [
            'pInscription' => $inscription,]);
    }

    public function ajouter(Request $request, PersistenceManagerRegistry $doctrine): Response
    {
        $inscription = new inscription();
        $form = $this->createForm(InscriptionType::class, $inscription);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($inscription);
            $entityManager->flush();

            $this->addFlash('success', 'Inscription created successfully!');
            return $this->redirectToRoute('inscriptionLister');
        }

        return $this->render('inscription/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function modifier(Request $request, PersistenceManagerRegistry $doctrine, int $id): Response
    {

        $inscription = $doctrine->getRepository(Inscription::class)->find($id);


        if (!$inscription) {
            throw $this->createNotFoundException('L\'inscription n\'existe pas');
        }

        $form = $this->createForm(InscriptionModifierType::class, $inscription);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('inscriptionConsulter', ['id' => $inscription->getId()]);
        }

        return $this->render('inscription/modifier.html.twig', [
            'form' => $form->createView(),
            'inscription' => $inscription,
        ]);
    }

    public function supprimer(PersistenceManagerRegistry $doctrine, int $id)
    {
        $entityManager = $doctrine->getManager();
        $inscription = $entityManager->find(Inscription::class, $id);

        if (!$inscription) {
            throw $this->createNotFoundException("Pas d'inscription avec et ID !");
        }

        $entityManager->remove($inscription);
        $entityManager->flush();

        return $this->redirectToRoute('inscriptionLister');
    }

}
