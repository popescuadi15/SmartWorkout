<?php

namespace App\Form\Type;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nume', TextType::class, [
                'label' => 'Nume',
            ])
            ->add('mail', EmailType::class, [
                'label' => 'Email',
            ])
            ->add('birth_day', BirthdayType::class, [
                'label' => 'Data nașterii',
            ])
            ->add('gender', ChoiceType::class, [
                'label' => 'Sex',
                'choices' => [
                    'Masculin' => 0,
                    'Feminin' => 1,
                    'Altul' => 2,
                    'Prefer să nu spun' => 3,
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
