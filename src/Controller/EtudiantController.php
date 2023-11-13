<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Etudiant;
use App\Entity\Maison;
use Doctrine\Persistence\ManagerRegistry;

class EtudiantController extends AbstractController
{
    //#[Route('/etudiant', name: 'app_etudiant')]
    public function index(): Response
    {
        return $this->render('etudiant/index.html.twig', [
            'controller_name' => 'EtudiantController',
        ]);
    }

    //#[Route('/etudiant/accueil', name: 'app_accueil')]
    public function accueil(): Response
    {
        $annee = '2024';
        return $this->render('etudiant/accueil.html.twig', [
            'pAnnee' => $annee,
        ]);
    }

    //#[Route('/etudiant/ajouter', name: 'etudiantAjouter')]
    public function ajouterEtudiant(){
 
		$etudiant = new etudiant();
		$form = $this->createForm(EtudiantType::class, $etudiant);
                return $this->render('etudiant/ajouter.html.twig', array(
                'form' => $form->createView(), ));
    }

    //#[Route('/etudiant/consulter/{id}', name: 'etudiantConsulter')]
    public function consulter(ManagerRegistry $doctrine, int $id){

		$etudiant= $doctrine->getRepository(Etudiant::class)->find($id);

		if (!$etudiant) {
			throw $this->createNotFoundException(
            'Aucun etudiant trouvé avec le numéro '.$id
			);
		}

		//return new Response('Etudiant : '.$etudiant->getNom());
		return $this->render('etudiant/consulter.html.twig', [
            'etudiant' => $etudiant,]);
	}

    //#[Route('/etudiant/lister', name: 'etudiantLister')]
    public function lister(ManagerRegistry $doctrine){

        $repository = $doctrine->getRepository(Etudiant::class);

        $etudiants= $repository->findAll();
        return $this->render('etudiant/lister.html.twig', [
            'pEtudiants' => $etudiants,]);   
    }

	//#[Route('/etudiant/{id}', name='etudiant_show')]
	public function show(Etudiant $unEtudiant)
	{
		return $this->render('etudiant/consulter.html.twig', [
            'etudiant' => $unEtudiant,]);
	}

    //#[Route("/etudiant/consulterParNomPrenom/{nom}/{prenom}", name="consulterEtudiantParNomPrenom")]
    public function consulterParNomPrenom(ManagerRegistry $doctrine, $nom,$prenom){
		$repository = $doctrine->getRepository(Etudiant::class);
		$etudiant = $repository->findOneBy(
			['nom' => $nom,'prenom' => $prenom ]
		);
 
		return $this->render('etudiant/consulter.html.twig', [
            'etudiant' => $etudiant,]);
	}

    //#[Route("/etudiant/consulterEtudiantsDateNaissSuperieur/{dateNaiss}", name="consulterEtudiantsDateNaissSuperieur")]
    public function consulterEtudiantsDateNaissSuperieur(ManagerRegistry $doctrine, $dateNaiss){
 
		$repository = $doctrine->getRepository(Etudiant::class);
		$etudiants = $repository->consulterEtudiantParDateNaissSup($dateNaiss);
 
		return $this->render('etudiant/lister.html.twig', [
            'pEtudiants' => $etudiants,]);	
	}

    //#[Route("/etudiant/modifier/{id}", name="etudiantModifier")]
    public function modifierEtudiant(ManagerRegistry $doctrine, $id){
 
		//récupération de l'étudiant dont l'id est passé en paramètre
		$etudiant= $doctrine->getRepository(Etudiant::class)->find($id);
 
		if (!$etudiant) {
			throw $this->createNotFoundException(
            'Aucun etudiant trouvé avec le numéro '.$id
			);
		}
		else
		{  
		    // récupération de la maison des griffondor à partir du code de la maison
            $maison= $doctrine->getRepository(Maison::class)->findOneBy(['code' => 'GRI']);
 
            if (!$maison) {
                throw $this->createNotFoundException(
                'Aucune maison trouvé avec ce nom'
                );
            }
            else
            {
            //Affectation de la maison à l'étudiant
            $etudiant->setMaison($maison);
    
            // persistence de l'objet modifié
            $entityManager = $doctrine->getManager();
            $entityManager->persist($etudiant);
            $entityManager->flush();
   
            //return new Response('Etudiant : '.$etudiant->getNom());
            return $this->render('etudiant/consulter.html.twig', [
                'etudiant' => $etudiant,]);
            }
        }
	}
}