<?php

namespace App\Form;

use App\Entity\Enseignant;
use App\Entity\Etudiant;
use App\Entity\Salle;
use App\Entity\Soutenance;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SoutenanceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('etudiant', EntityType::class, [
                'class' => Etudiant::class,
                'choice_label' => fn(Etudiant $etudiant) => $etudiant->getNom() . ' ' . $etudiant->getPrenom(),
            ])
            ->add('president', EntityType::class, [
                'class' => Enseignant::class,
                'choice_label' => fn(Enseignant $enseignant) => $enseignant->getNom() . ' ' . $enseignant->getPrenom(),
                'label' => 'Président du jury',
            ])
            ->add('rapporteur', EntityType::class, [
                'class' => Enseignant::class,
                'choice_label' => fn(Enseignant $enseignant) => $enseignant->getNom() . ' ' . $enseignant->getPrenom(),
            ])
            ->add('examinateur', EntityType::class, [
                'class' => Enseignant::class,
                'choice_label' => fn(Enseignant $enseignant) => $enseignant->getNom() . ' ' . $enseignant->getPrenom(),
            ])
            ->add('salle', EntityType::class, [
                'class' => Salle::class,
                'choice_label' => 'code',
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('heure', TimeType::class, [
                'widget' => 'single_text',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Soutenance::class,
        ]);
    }
}