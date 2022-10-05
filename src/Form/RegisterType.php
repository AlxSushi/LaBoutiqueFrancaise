<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Entrez votre prénom',
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre prénom'
                ]])
            ->add('lastname', TextType::class, [
                'label' => 'Entrez votre nom de famille',
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre nom de famille'
                ]])
            ->add('email', EmailType::class, [
                'label' => 'Entrez votre email',
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre email'
                ]])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message'=> 'Vos mots de passe ne correspondent pas',
                'label'=> 'Mot de passe',
                'required' => true,
                'first_options' => ['label'=> 'Entrez votre mot de passe'],
                'second_options'=> ['label'=> 'Confirmez votre mot de passe'],
                ])
            ->add('submit', SubmitType::class, [
                'label' => 'S\'inscrire'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
