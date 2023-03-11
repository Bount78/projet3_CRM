<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Consent;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\File;

class RegistrationFormType extends AbstractType
{
    private $translator;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, TranslatorInterface $translator)
    {
        $this->entityManager = $entityManager;
        $this->translator = $translator;
    }


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
                'attr' => ['type' => 'email'],
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Tapez votre mot de passe : ',
                    'attr' => ['class' => 'form-control mb-3 ']
                ],
                'second_options' => [
                    'label' => 'Retapez votre mot de passe : ',
                    'attr' => ['class' => 'form-control mb-3 ']
                ],
                'required' => true,
                'invalid_message' => 'Les mots de passe ne correspondent pas.'
            ])
            ->add('profileImage', FileType::class, [
                'label' => 'Image de profil (JPG, PNG, GIF)',
                'required' => false,
                'attr' => [
                    'accept' => '.jpg,.jpeg,.png,.gif'
                ],
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif'
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger une image au format JPG, PNG ou GIF',
                    ])
                ]
            ])
            ->add('consent', CheckboxType::class, [
                'mapped' => false,
                'label' => 'J\'accepte les termes et conditions, ainsi que la collecte et le traitement de mes données personnelles conformément à votre politique de confidentialité',
                'required' => true,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter la politique de confidentialité pour continuer.'
                    ])
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'S\'inscrire',
                'attr' => ['class' => 'btn btn-primary btn-lg btn-block mt-4']
            ]);



            $builder->addEventListener(
                FormEvents::POST_SUBMIT,
                function (FormEvent $event) {
                    $form = $event->getForm();
    
                    if (!$form->isValid()) {
                        return;
                    }
    
                    $user = $event->getData();
    
                    if ($form->get('consent')->getData()) {
                        $consent = new Consent();
                        $consent->setUser($user);
                        $consent->setAccept(true);
                        $consent->setDateConsenti(new \DateTimeImmutable());
                        $this->entityManager->persist($consent);
                    }
    
                    $this->entityManager->persist($user);
                    $this->entityManager->flush();
                }
            );
        }
    }