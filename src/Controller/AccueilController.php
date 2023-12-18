<?php

namespace App\Controller;

use App\Entity\ContratPret;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccueilController extends AbstractController
{
    public function accueil(ManagerRegistry $doctrine)
    {

        return $this->render('general/accueil.html.twig');

    }
}