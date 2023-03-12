<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordFormType;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ChangePasswordController extends AbstractController
{
    private $passwordHasher;
    private $entityManager;

    public function __construct(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager)
    {
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
    }

    #[Route('/profile/change-password', name: 'app_change_password')]
    public function index(Request $request): Response
    {
        $changePasswordForm = $this->createForm(ChangePasswordFormType::class);
        $changePasswordForm->handleRequest($request);

        if ($changePasswordForm->isSubmitted() && $changePasswordForm->isValid()) {
            /** @var User $user */
            $user = $this->getUser();

            // Vérifier si l'ancien mot de passe est correct
            $oldPassword = $changePasswordForm->get('oldPassword')->getData();
            if (!$this->passwordHasher->isPasswordValid($user, $oldPassword)) {
                $changePasswordForm->get('oldPassword')->addError(new FormError('Le mot de passe actuel est incorrect.'));
            } else {
                // Mettre à jour le mot de passe
                $newPassword = $changePasswordForm->get('newPassword')->getData();
                $user->setPassword($this->passwordHasher->hashPassword($user, $newPassword));

                $entityManager = $this->entityManager;
                $entityManager->flush();

                $this->addFlash('success', 'Votre mot de passe a été modifié.');

                return $this->redirect($request->headers->get('referer'));
            }
        }

        return $this->render('change_password/index.html.twig', [
            'changePasswordForm' => $changePasswordForm->createView(),
        ]);
    }
}
