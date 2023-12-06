<?php

// src/Controller/InscriptionController.php

namespace App\Controller;

use App\Entity\Cours;
use App\Entity\Eleve;
use App\Entity\Inscription;
use Doctrine\ORM\EntityManagerInterface;
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
    public function inscrireEleveCours(Request $request, $idCours, $idEleve): Response
    {
        // Récupérer le cours et l'élève
        $cours = $this->entityManager->getRepository(Cours::class)->find($idCours);
        $eleve = $this->entityManager->getRepository(Eleve::class)->find($idEleve);

        if (!$cours || !$eleve) {
            throw $this->createNotFoundException('Cours ou élève non trouvé.');
        }

        // Créer une nouvelle inscription
        $inscription = new Inscription();
        $inscription->setCours($cours);
        $inscription->setEleve($eleve);
        $inscription->setDateInscription(new \DateTime());

        // Sauvegarder l'inscription
        $this->entityManager->persist($inscription);
        $this->entityManager->flush();

        // Redirection vers une page de confirmation ou autre
        return $this->redirectToRoute('confirmation_inscription');
    }

}
