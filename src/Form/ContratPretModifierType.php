<?php

namespace App\Form;

use App\Entity\ContratPret;
use App\Entity\Couleur;
use App\Entity\Eleve;
use App\Entity\Intervention;
use App\Entity\Responsable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class ContratPretModifierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('eleve', EntityType::class, array('class' => 'App\Entity\Eleve','choice_label' => 'nom', 'attr' => ['class' => 'form-control'] ))
            ->add('instrument', EntityType::class, array('class' => 'App\Entity\Instrument','choice_label' => 'numSerie', 'attr' => ['class' => 'form-control'] ))
            ->add('attestationAssurance', TextType::class, array('attr' => ['class' => 'form-control']))
            ->add('interventions', EntityType::class, [
                'class' => Intervention::class,
                'choice_label' => 'id',
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,
                'label' => 'test',
                'attr' => ['class' => 'form-select']
            ])
            ->add('etatDetailleDebut', TextareaType::class, array('attr' => ['class' => 'form-control']))
            ->add('etatDetailleRetour', TextareaType::class, array('attr' => ['class' => 'form-control']))
            ->add('dateDebut', DateType::class, ['widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'attr' => ['class' => 'form-control']])
            ->add('dateFin', DateType::class, ['widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'attr' => ['class' => 'form-control']])
            ->add('save', SubmitType::class, array('label' => 'Créer', 'attr' => ['class' => 'btn btn-primary']));
    }
}