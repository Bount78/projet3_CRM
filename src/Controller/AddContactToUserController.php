<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AddContactToUserController extends AbstractController
{
    #[Route('/user/{userId}/contact/{contactId}/link', name: 'add_contact', methods: ['POST'])]
    public function addContact(Request $request, int $userId, int $contactId, EntityManagerInterface $entityManager, SerializerInterface $serializer)
    {
        // Retrieve the logged in user
        $user = $entityManager
            ->getRepository(User::class)
            ->find($userId);

        // Retrieve the contact corresponding to the ID
        $contact = $entityManager
            ->getRepository(Contact::class)
            ->find($contactId);

        // Verify that the contact exists
        if (!$contact) {
            return $this->json(['message' => 'Le contact n\'existe pas'], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Verify that the contact is not already linked to the user
        if ($user->getContacts()->contains($contact)) {
            // Si le contact est déjà lié à l'utilisateur, retourner une erreur
            return $this->json(['message' => 'Le contact est déjà lié à l\'utilisateur'], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Assign the user to the contact
        $contact->addUser($user);

        // Record the contact in the database
        $entityManager->flush();

        // Return a PHP array with a success message
        return $this->json(['message' => 'Le contact a été ajouté avec succès']);
    }
}
