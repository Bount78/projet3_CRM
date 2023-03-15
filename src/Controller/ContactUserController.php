<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\User;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactUserController extends AbstractController
{
    #[Route('/user/contacts', name: 'user_contacts')]
    public function index(ContactRepository $contactRepository, Security $security)
    {
        $user = $security->getUser();
        $contacts = $contactRepository->findByUser($user);

        return $this->render('contact_user/contacts_user.html.twig', [
            'user' => $user,
            'contacts' => $contacts,
        ]);
    }

    #[Route('/contacts/{id}', name: 'app_delete_contact', methods: ['POST'])]
    public function removeContact(Request $request, Contact $contact, EntityManagerInterface $entityManager): Response
    {
        /** @var User $user */
        $user = $this->getUser();
    
        // Verify that the user is linked to the contact
        if (!$user->getContacts()->contains($contact)) {
            throw $this->createNotFoundException('Le contact demandé n\'existe pas.');
        }
    
        // Remove the relationship between the user and the contact
        $user->removeContact($contact);
        $entityManager->flush();
    
        // Display a confirmation message
        $this->addFlash('success', 'Le contact a été retiré de votre liste.');
    
        // Redirect user to contact list
        return $this->redirect($request->headers->get('referer'));
    }
    
}
