<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AddContactController extends AbstractController
{
    #[Route('/user/{userId}/contact/{contactId}/link', name: 'link_user_contact', methods: ['POST'])]
    public function linkUserContact(Request $request, EntityManagerInterface $entityManager, User $user, Contact $contact)
    {
        $user->addContact($contact);
        $entityManager->flush();

        return $this->redirectToRoute('show_contacts');
    }
}
