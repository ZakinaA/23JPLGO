<?php

namespace App\Controller;

use App\Entity\ContratPret;
use App\Entity\Eleve;
use App\Entity\Instrument;
use App\Entity\InterPret;
use App\Entity\Intervention;
use App\Entity\Responsable;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        $contratPret = $doctrine->getRepository(ContratPret::class)->find($id);
        $repository = $doctrine->getRepository(Intervention::class);
        $interventions= $repository->findAll();
        if (!$contratPret) {
            throw $this->createNotFoundException(
                'Aucun instrument trouvé avec l\'ID '.$id
            );
        }
        return $this->render('contratPret/consulter.html.twig', [
            'contratPrets' => $contratPret,
            'interventions' => $interventions,
        ]);
    }
}