<?php

namespace App\Form\Type;

use App\Entity\Exercise;
use App\Entity\Tip;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class UserType extends AbstractType
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
            ->add('parola', PasswordType::class, [
                'label' => 'Parola',
            ])
             ->add('birth_day', BirthdayType::class, [
                 'label' => 'Data nasterii',
    ])
            ->add('gender', ChoiceType::class, [
                'choices'  => [
                    'Masculin' => 0,
                    'Feminin' => 1,
                    'Other' => 2,
                    'Prefer not to say' => 3,
                ],
            ])

        ->add('Sign_up', SubmitType::class, [
        'label' => 'Sign Up',
        'attr' => ['class' => 'btn btn-primary', 'id' => 'add-signup-btn'],
    ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
