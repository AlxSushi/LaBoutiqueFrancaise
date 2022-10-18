<?php

namespace App\Form;

use App\Entity\User;
use PharIo\Manifest\Email;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'disabled' => true,
                'label' => 'mon adresse email'
            ])
            ->add('firstname', TextType::class, [
                'disabled' => true,
                'label' => 'mon prénom'
            ])
            ->add('lastname', TextType::class, [
                'disabled' => true,
                'label' => 'mon nom'
            ])
            ->add('old_password', PasswordType::class, [
                'label' => 'Entrez votre mot de passe actuel',
                'mapped'=> false,
            ])
            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Vos mots de passe ne correspondent pas',
                'label' => 'Mot de passe',
                'mapped' => false,
                'required' => true,
                'first_options' => ['label' => 'Entrez votre nouveau mot de passe'],
                'second_options' => ['label' => 'Confirmez votre nouveau mot de passe'],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
