<?php

namespace App\Controller;

use App\Entity\ContratPret;
use App\Entity\Cours;
use App\Entity\Eleve;
use App\Entity\Instrument;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccueilController extends AbstractController
{
    public function accueil(ManagerRegistry $doctrine)
    {

        $repository = $doctrine->getRepository(ContratPret::class);
        $contratsPret= $repository->findAll();

        $repository = $doctrine->getRepository(Eleve::class);
        $eleves= $repository->findAll();

        $repository = $doctrine->getRepository(Instrument::class);
        $instruments= $repository->findAll();

        $repository = $doctrine->getRepository(Cours::class);
        $cours= $repository->findAll();

        return $this->render('general/accueil.html.twig', [
            'contratsPret' => $contratsPret,
            'eleves' => $eleves,
            'instruments' => $instruments,
            'cours' => $cours,
        ]);

    }
}