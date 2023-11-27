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

class ContratPretType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('eleve', EntityType::class, array('class' => 'App\Entity\Eleve','choice_label' => 'nom' ))
            ->add('instrument', EntityType::class, array('class' => 'App\Entity\Instrument','choice_label' => 'id' ))
            ->add('dateDebut', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('dateFin', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('attestationAssurance', TextType::class)
            ->add('etatDetailleDebut', TextType::class)
            ->add('etatDetailleRetour', TextType::class)
	    ->add('save', SubmitType::class, array('label' => 'Créer'));
    }//à modifier, les noms (child)
}