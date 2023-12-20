<?php

namespace App\Form;

use App\Entity\Eleve;
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
use Symfony\Component\Validator\Constraints\Range;

class ResponsableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('nom', TextType::class, array('attr' => ['class' => 'form-control']))
            ->add('prenom', TextType::class, array('attr' => ['class' => 'form-control']))
            ->add('numRue', NumberType::class, array('attr' => ['class' => 'form-control']))
            ->add('rue', TextType::class, array('attr' => ['class' => 'form-control']))
            ->add('copos', NumberType::class, array('attr' => ['class' => 'form-control']))
            ->add('ville', TextType::class, array('attr' => ['class' => 'form-control']))
            ->add('tel', TextType::class, array('attr' => ['class' => 'form-control']))
            ->add('mail', TextType::class, array('attr' => ['class' => 'form-control']))
            ->add('enregistrer', SubmitType::class, array('label' => 'Nouveau responsable', 'attr' => ['class' => 'btn btn-primary']))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Responsable::class,
        ]);
    }
}
