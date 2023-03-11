<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AddContactToUserController extends AbstractController
{
    #[Route('/user/{userId}/contact/{contactId}/link', name: 'add_contact', methods: ['POST'])]
    public function addContact(Request $request, int $userId, int $contactId, EntityManagerInterface $entityManager): JsonResponse
    {

        $contact = $entityManager->getRepository(Contact::class)->find($contactId);
        // Récupérer l'utilisateur connecté
        $user = $entityManager
            ->getRepository(User::class)
            ->find($userId);

        // Récupérer le contact correspondant à l'ID
        $contact = $entityManager
            ->getRepository(Contact::class)
            ->find($contactId);

        // Vérifier que le contact existe
        if (!$contact) {
            return new JsonResponse(['message' => 'Le contact n\'existe pas'], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Vérifier que le contact n'est pas déjà lié à l'utilisateur
        if ($user->getContacts()->contains($contact)) {
            // Si le contact est déjà lié à l'utilisateur, retourner une erreur
            return new JsonResponse(['message' => 'Le contact est déjà lié à l\'utilisateur'], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Assigner l'utilisateur au contact
        $contact->addUser($user);

        // Enregistrer le contact dans la base de données
        $entityManager->flush();

        // Ajouter un message flash pour afficher la confirmation
        $this->addFlash('success', 'Le contact a été ajouté avec succès.');

        // Rediriger vers la page liste_contacts.html.twig
        return new JsonResponse(['message' => 'Le contact a été ajouté avec succès']);

    }
}
