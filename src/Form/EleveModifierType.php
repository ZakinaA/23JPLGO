<?php

namespace App\Form;

use App\Entity\Eleve;
use App\Entity\Responsable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Validator\Constraints\Range;

class EleveModifierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom',)
            ->add('numRue',)
            ->add('rue',)
            ->add('copos')
            ->add('ville')
            ->add('tel')
            ->add('mail')
            ->add('responsables', EntityType::class, [
                'class' => Responsable::class,
                'choice_label' => 'nom', // Replace 'name' with the actual property you want to display
                'multiple' => true,
                'expanded' => false, // If you want checkboxes instead of a dropdown
            ])
            ->add('enregistrer', SubmitType::class, array('label' => 'Modifier l\'élève'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Eleve::class,
        ]);
    }
}
