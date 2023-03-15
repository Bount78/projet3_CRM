<?php

namespace App\Controller;

use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ListeContactController extends AbstractController
{
    #[Route('/user/liste_contacts', name: 'liste_contacts')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $contacts = $entityManager->getRepository(Contact::class)->findAll();

        return $this->render('liste_contact/liste_contacts.html.twig', [
            'contacts' => $contacts,
        ]);
    }


    #[Route('/get-contacts', name: 'get_contacts')]
    public function getContacts(EntityManagerInterface $entityManager): Response
    {
        $contacts = $entityManager->getRepository(Contact::class)->findAll();
        // Convert Contact List to JSON
        $contactsJson = [];
        foreach ($contacts as $contact) {
            $contactsJson[] = [
                'id' => $contact->getId(),
                'firstName' => $contact->getFirstName(),
                'lastName' => $contact->getLastName(),
            ];
        }
        $response = new JsonResponse($contactsJson);

        return $response;
    }
}
