<?php

namespace App\Form;

use App\Entity\Eleve;
use App\Entity\Inscription;
use App\Entity\Responsable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\Range;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateInscription', DateType::class, [
                'attr' => ['class' => 'form-control'],
                'data' => new \DateTime(),
            ])
            ->add('eleve', EntityType::class, [
                'class' => 'App\Entity\Eleve',
                'choice_label' => function ($eleve){
                    return $eleve->getNom() . ' ' . $eleve->getPrenom();
                },
                'attr' => ['class' => 'form-control']
            ])
            ->add('cours', EntityType::class, [
                'class' => 'App\Entity\Cours',
                'choice_label' => 'libelle',
                'attr' => ['class' => 'form-control']
            ])
            ->add('enregistrer', SubmitType::class, array('label' => 'Ajouter Inscription'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inscription::class,
        ]);
    }
}
