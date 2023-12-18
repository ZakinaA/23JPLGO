<?php
namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Instrument;
use App\Entity\Marque;
use App\Entity\TypeInstrument;
use App\Entity\Couleur;
use Symfony\Component\Validator\Constraints\Range;

class InstrumentModifierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numSerie', TextType::class, [
                'label' => 'Nom',
                'attr' => ['class' => 'form-control']
            ])
            ->add('dateAchat', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => ['class' => 'form-control']
            ])
            ->add('prixAchat', MoneyType::class, [
                'label' => 'Prix d\'achat',
                'constraints' => [
                    new Range([
                        'min' => 0, // Set the minimum value to 0
                        'minMessage' => 'Le prix d\'achat ne peut pas être négatif.',
                    ]),
                ],
                'attr' => ['class' => 'form-control']
            ])
            ->add('utilisation', TextType::class, [
                'label' => 'Utilisation',
                'attr' => ['class' => 'form-control']
            ])
            ->add('marque', EntityType::class, [
                'class' => Marque::class,
                'choice_label' => 'libelle',
                'label' => 'Marque',
                'attr' => ['class' => 'form-control']
            ])
            ->add('TypeInstrument', EntityType::class,  [
                'class' => TypeInstrument::class,
                'choice_label' => 'libelle',
                'label' => 'Type d\'Instrument',
                'attr' => ['class' => 'form-control']
            ])
            ->add('couleurs', EntityType::class, [
                'class' => Couleur::class,
                'choice_label' => 'Nom',
                'multiple' => true,
                'expanded' => true,
                'label' => 'Couleur',
            ])
            ->add('cheminImage', TextType::class, [ // Add this block
                'label' => 'Chemin de l\'Image',
                'required' => false, // Depending on your requirements
                'attr' => ['class' => 'form-control']
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Instrument::class,
        ]);
    }
}
