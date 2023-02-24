<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastName', TextType::class,[
                'label'=>'Votre nom :',
                'attr'=>[
                    'placeholder'=>'Entrez votre nom...'
                ]
            ])
            ->add('email', EmailType::class, [
                'label'=> 'Votre email : ',
                'attr'=>[
                    'placeholder'=>'Entrez votre adresse mail...'
                ]
            ])
            ->add('password', PasswordType::class, [
                'label'=> 'Votre password : ',
                'attr'=>[
                    'placeholder'=> 'Entrez votre mot de passe...'
                ]
                ])
            // ->add('roles')
            // ->add('firstName')
            // ->add('profileImage')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
