<?php

namespace App\Controller;

use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ListeContactController extends AbstractController
{
    #[Route('/user/liste_contacts', name: '/liste_contacts')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $contacts = $entityManager->getRepository(Contact::class)->findAll();

        return $this->render('liste_contact/liste_contacts.html.twig', [
            'contacts' => $contacts,
        ]);
    }
}
