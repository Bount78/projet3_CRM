<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Votre prénom : ',
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Votre nom : ',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre Email : ',
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Tapez votre mot de passe'],
                'second_options' => ['label' => 'Retapez votre mot de passe'],
            ])
            ->add('profileImage', FileType::class, [
                'label' => 'Image de profil (JPG, PNG, GIF)',
                'required' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'S\'enregistrer',
                'attr' => ['class' => 'btn btn-primary'],
            ]);
            

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
