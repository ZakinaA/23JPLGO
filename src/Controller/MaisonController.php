<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Etudiant;
use App\Entity\Maison;
use Doctrine\Persistence\ManagerRegistry;

class MaisonController extends AbstractController
{
    //#[Route('/maison', name: 'app_maison')]
    public function index(): Response
    {
        return $this->render('maison/index.html.twig', [
            'controller_name' => 'MaisonController',
        ]);
    }

    //#[Route('/maison/consulter/{code}', name: 'maisonConsulter')]
    public function consulterMaison(ManagerRegistry $doctrine, $code){
		$repository = $doctrine->getRepository(Maison::class);
		$maison= $doctrine->getRepository(Maison::class)->findOneBy(['code' => 'GRI']);
 
		return $this->render('maison/consulter.html.twig', ['pMaison' => $maison,]);			
	}
}