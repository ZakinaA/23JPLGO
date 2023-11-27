<?php

namespace App\Form;

use App\Entity\Couleur;
use App\Entity\Instrument;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InstrumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numSerie', TextType::class)
            ->add('dateAchat')
            ->add('prixAchat')
            ->add('utilisation', TextType::class)
            ->add('cheminImage', TextType::class)
            ->add('marque', EntityType::class, array('class' => 'App\Entity\Marque','choice_label' => 'libelle' ))
            ->add('TypeInstrument', EntityType::class, array('class' => 'App\Entity\TypeInstrument','choice_label' => 'libelle' ))
            ->add('couleurs', EntityType::class, [
                'class' => Couleur::class,
                'choice_label' => 'nom', // Replace 'name' with the actual property you want to display
                'multiple' => true,
                'expanded' => true, // If you want checkboxes instead of a dropdown
            ])
            ->add('save', SubmitType::class, array('label' => 'Créer'));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Instrument::class,
        ]);
    }
}
