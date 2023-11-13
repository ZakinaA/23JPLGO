<?php

namespace App\Form;

use App\Entity\Etudiant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class EtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('dateNaiss', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                 ])
            ->add('ville', TextType::class)
            ->add('numRue', TextType::class)
            ->add('rue', TextType::class)
            ->add('copos', TextType::class)
            ->add('surnom', TextType::class)
            ->add('maison', EntityType::class, array('class' => 'App\Entity\Maison','choice_label' => 'nom' ))
            //->add('promotion')
	    ->add('enregistrer', SubmitType::class, array('label' => 'Nouvel étudiant'))
        ;
    }
}