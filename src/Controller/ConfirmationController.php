<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConfirmationController extends AbstractController
{
    /**
     * @Route("/confirmation_inscription", name="confirmation_inscription")
     */
    public function confirmationInscription(): Response
    {
        return $this->render('confirmation/inscription.html.twig');
    }
}
