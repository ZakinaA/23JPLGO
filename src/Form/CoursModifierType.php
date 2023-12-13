<?php

namespace App\Form;

use App\Entity\Cours;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Validator\Constraints\Range;

class CoursModifierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', TextType::class, array('attr' => ['class' => 'form-control']))
            ->add('ageMini', null, ['constraints' => [new Range(['min' => 0])], 'attr' => ['class' => 'form-control']])
            ->add('ageMaxi', null, ['constraints' => [new Range(['min' => 0])], 'attr' => ['class' => 'form-control']])
            ->add('nbPlaces', null, ['constraints' => [new Range(['min' => 0])], 'attr' => ['class' => 'form-control']])
            ->add('heureDebut', TimeType::class, array('attr' => ['class' => 'form-control']))
            ->add('heureFin', TimeType::class, array('attr' => ['class' => 'form-control']))
            ->add('jour', EntityType::class, array('class' => 'App\Entity\Jour','choice_label' => 'libelle','attr' => ['class' => 'form-control'] ))
            ->add('typeCours', EntityType::class, array('class' => 'App\Entity\TypeCours','choice_label' => 'libelle', 'attr' => ['class' => 'form-control'] ))
            ->add('professeur', EntityType::class, array('class' => 'App\Entity\Professeur','choice_label' => 'nom', 'attr' => ['class' => 'form-control'] ))
            ->add('typeInstrument', EntityType::class, array('class' => 'App\Entity\TypeInstrument','choice_label' => 'libelle', 'attr' => ['class' => 'form-control'] ))
            ->add('enregistrer', SubmitType::class, array('label' => 'Nouveau Cours'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }
}
