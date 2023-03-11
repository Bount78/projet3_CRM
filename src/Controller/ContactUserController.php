<?php

use App\Entity\User;
use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactUserController extends AbstractController
{
    #[Route('/contact/user', name: 'app_contact_user')]
    #[ParamConverter("user", class: User::class)]
    public function index(EntityManagerInterface $entityManager, User $user): Response
    {
        $userId = $user->getId();

        $contacts = $entityManager->createQueryBuilder()
            ->select('c')
            ->from(Contact::class, 'c')
            ->join('c.user_contact', 'uc')
            ->where('uc.id = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();

        return $this->render('contact_user/contacts_user.html.twig', [
            'contacts' => $contacts,
        ]);
    }
}
