<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;



class LoginFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', EmailType::class, [
            'label'=> 'Votre email : ',
            'attr'=>[
                'placeholder'=>'Entrez votre adresse mail...',
                'name' => '_username'
            ]
        ])  
        ->add('password', PasswordType::class, [
            'label'=> 'Votre password : ',
            'attr'=>[
                'placeholder'=> 'Entrez votre mot de passe...',
                'name' => '_password'
            ]
        ]);
    }
        

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
