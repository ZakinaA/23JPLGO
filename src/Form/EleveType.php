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
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\Range;

class EleveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class)
            ->add('prenom',)
            ->add('numRue',)
            ->add('rue',)
            ->add('copos')
            ->add('ville')
            ->add('tel')
            ->add('mail')

            ->add('responsables', EntityType::class, [
                'class' => Responsable::class,
                'choice_label' => function ($responsable) {
                return $responsable->getNom() . ' ' . $responsable->getPrenom();
                },
                'multiple' => true,
                'expanded' => false,
                'constraints' => [
                    new Count(['max' => 2, 'maxMessage' => 'Vous ne pouvez sélectionner que deux responsables maximum']),
                ],
            ])
            ->add('enregistrer', SubmitType::class, array('label' => 'Nouvel Eleve'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Eleve::class,
        ]);
    }
}
