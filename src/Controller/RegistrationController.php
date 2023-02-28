<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'register')]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer l'objet UploadedFile
            $file = $form->get('profileImage')->getData();

            // Récupérer le prénom de l'utilisateur
            $firstName = $form->get('firstName')->getData();

            // Générer un nom de fichier unique
            $fileName = $firstName . '_profile_' . uniqid() . '.' . $file->guessExtension();

            // Déplacer le fichier vers le dossier de destination
            $file->move(
                $this->getParameter('profile_image_directory'),
                $fileName
            );

            // Mettre à jour la propriété profileImage de l'utilisateur avec le nom de fichier
            $user->setProfileImage($fileName);

            // Encode the plain password
            $hashedPassword = $passwordHasher->hashPassword($user, $form->get('password')->getData());
            $user->setPassword($hashedPassword);

            // Save the user to the database
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Votre compte a été créé avec succès. Vous pouvez vous connecter.');

            return $this->redirectToRoute('app_login');
        }

        $loginLink = $this->generateUrl('app_login');

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            'login_link' => $loginLink
        ]);
    }
}
