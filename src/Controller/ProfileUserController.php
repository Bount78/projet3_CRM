<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditProfileFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfileUserController extends AbstractController
{
    #[Route('/profile/user', name: 'app_profile_user')]
    public function index(Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        // Vérifier si l'utilisateur a le rôle ROLE_USER
        if (!$this->isGranted('ROLE_USER')) {
            throw $this->createAccessDeniedException();
        }

        // Formulaire de modification de profil
        $editProfileForm = $this->createForm(EditProfileFormType::class, $user);
        $editProfileForm->handleRequest($request);

        if ($editProfileForm->isSubmitted() && $editProfileForm->isValid()) {
            // Récupérer le fichier de la nouvelle image de profil
            $profileImageFile = $editProfileForm->get('profileImage')->getData();

            if ($profileImageFile) {
                // Supprimer l'ancienne image de profil
                $this->deleteProfileImage($user);

                // Renommer et enregistrer la nouvelle image de profil
                $fileName = $user->getFirstName() . '_profile_' . uniqid() . '.' . $profileImageFile->guessExtension();
                $profileImageFile->move(
                    $this->getParameter('profile_image_directory'),
                    $fileName
                );
                $user->setProfileImage($fileName);
            }

            $entityManager->flush();

            $this->addFlash('success', 'Vos informations personnelles ont été mises à jour.');

            return $this->redirect($request->headers->get('referer'));
        }

        return $this->render('profile_user/index.html.twig', [
            'user' => $user,
            'editProfileForm' => $editProfileForm->createView(),
        ]);
    }

    /**
     * Supprime l'ancienne image de profil d'un utilisateur.
     */
    private function deleteProfileImage(User $user): void
    {
        // Récupérer le nom du fichier de l'image de profil
        $fileName = $user->getProfileImage();

        if ($fileName) {
            // Supprimer le fichier de l'image de profil
            $filePath = $this->getParameter('profile_image_directory') . '/' . $fileName;
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Supprimer le nom du fichier de l'image de profil de l'entité User
            $user->setProfileImage(null);
        }
    }
}
