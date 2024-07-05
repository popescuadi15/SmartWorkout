<?php

namespace App\Form\Type;

use App\Entity\Exercise;
use App\Entity\Tip;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExerciseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nume', TextType::class, [
                'label' => 'Nume exercitiu',
            ])
            ->add('linkVideo', TextType::class, [
                'label' => 'Link video',
            ])
            ->add('tip', EntityType::class, [
                'class' => Tip::class,
                'choice_label' => 'nume',
                'placeholder' => 'Select a type',
                'label' => 'Tip',
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Exercise::class,
        ]);
    }
}
