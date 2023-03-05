<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EventController extends AbstractController
{

    #[Route('/app_event_add', name: 'app_event_add', methods: ['GET', 'POST'])]
    public function addEvent(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($event);
            $entityManager->flush();

            return new JsonResponse([
                'success' => true,
                'message' => 'L\'événement a été ajouté avec succès'
            ]);
        }

        // Collecter les erreurs de validation
        $errors = [];
        foreach ($form->getErrors(true) as $error) {
            $errors[$error->getOrigin()->getName()][] = $error->getMessage();
        }

        return new JsonResponse([
            'success' => false,
            'message' => 'Le formulaire n\'est pas valide',
            'errors' => $errors
        ], 400);
    }


}
