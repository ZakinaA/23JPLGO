<?php

namespace App\Form;

use App\Entity\ClasseInstrument;
use App\Entity\TypeInstrument;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeInstrumentModifierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle', TextType::class, [
                'label' => 'Libellé du type d\'instrument',
                'attr' => ['class' => 'form-control']
            ])
            ->add('classeInstrument', EntityType::class, [
                'class' => ClasseInstrument::class, // Assurez-vous d'importer la classe ClasseInstrument
                'choice_label' => 'libelle', // Remplacez par le champ que vous souhaitez afficher
                'label' => 'Classe d\'instrument',
                'attr' => ['class' => 'form-control']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TypeInstrument::class,
        ]);
    }
}
