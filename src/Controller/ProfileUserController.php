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

        // Check if the user has the ROLE_USER role
        if (!$this->isGranted('ROLE_USER')) {
            throw $this->createAccessDeniedException();
        }

        // Profile Change Form
        $editProfileForm = $this->createForm(EditProfileFormType::class, $user);
        $editProfileForm->handleRequest($request);

        if ($editProfileForm->isSubmitted() && $editProfileForm->isValid()) {
            // Recover the new profile image file
            $profileImageFile = $editProfileForm->get('profileImage')->getData();

            if ($profileImageFile) {
                // Delete the old profile image
                $this->deleteProfileImage($user);

                // Rename and save the new profile image
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
     * Removes a user’s old profile image.
     */
    private function deleteProfileImage(User $user): void
    {
        // Retrieve the profile image file name
        $fileName = $user->getProfileImage();

        if ($fileName) {
            // Delete the file from the profile image
            $filePath = $this->getParameter('profile_image_directory') . '/' . $fileName;
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Remove the file name from the User entity profile image
            $user->setProfileImage(null);
        }
    }
}
