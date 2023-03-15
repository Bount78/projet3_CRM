<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordFormType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Route;

class ChangePasswordController extends AbstractDashboardController
{
    private $passwordHasher;
    private $entityManager;

    public function __construct(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager)
    {
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
    }

    #[Route('/profile/change-password', name: 'app_change_password')]
    public function changePassword(Request $request, AdminUrlGenerator $adminUrlGenerator): Response
    {
        $changePasswordForm = $this->createForm(ChangePasswordFormType::class);
        $changePasswordForm->handleRequest($request);

        if ($changePasswordForm->isSubmitted() && $changePasswordForm->isValid()) {
            /** @var User $user */
            $user = $this->getUser();

            // Check if the old password is correct
            $oldPassword = $changePasswordForm->get('oldPassword')->getData();
            if (!$this->passwordHasher->isPasswordValid($user, $oldPassword)) {
                $changePasswordForm->get('oldPassword')->addError(new FormError('Le mot de passe actuel est incorrect.'));
            } else {
                // Update the password
                $newPassword = $changePasswordForm->get('newPassword')->getData();
                $user->setPassword($this->passwordHasher->hashPassword($user, $newPassword));

                $entityManager = $this->entityManager;
                $entityManager->flush();

                $this->addFlash('success', 'Votre mot de passe a été modifié.');

                return $this->redirect($request->headers->get('referer'));
            }
        }

        $changePasswordUrl = $adminUrlGenerator->setController(UserCrudController::class)->setAction('changePassword')->generateUrl();

        return $this->render('change_password/index.html.twig', [
            'changePasswordForm' => $changePasswordForm->createView(),
            'changePasswordUrl' => $changePasswordUrl,
        ]);
    }
}
