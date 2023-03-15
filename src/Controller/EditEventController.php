<?php

namespace App\Controller;

use DateTime;
use App\Entity\Event;
use App\Form\EventType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class EditEventController extends AbstractController
{
    #[Route('/event/edit/{id}', name: 'update_event', methods: ['PUT'])]
    public function updateEvent(Request $request, EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage, int $id): Response
    {
        // Retrieve Logged in User ID
        $user = $tokenStorage->getToken()->getUser();
    
        // Retrieve the event to be modified
        $eventRepository = $entityManager->getRepository(Event::class);
        $event = $eventRepository->findOneBy(['id' => $id, 'user' => $user]);
    
        if (!$event) {
            throw $this->createNotFoundException('Cet événement n\'existe pas');
        }
    
        // Update event data with form data
        $form = $this->createForm(EventType::class, $event);
        $form->submit($request->request->all(), false);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Persist changes in database
            $entityManager->flush();
    
            // Return modified event information
            $eventArray = [
                'id' => $event->getId(),
                'name' => $event->getName(),
                'dateStart' => $event->getDateStart()->format(DateTime::ATOM),
                'dateEnd' => $event->getDateEnd()->format(DateTime::ATOM)
            ];
    
            return $this->json(['success' => true, 'event' => $eventArray]);
        }
    
        return $this->json(['success' => false, 'errors' => $form->getErrors(true, false)]);
    }
    
    


    #[Route('/event/search', name: 'search_event')]
    public function searchEvent(Request $request, EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage): JsonResponse
    {
        // Retrieve the search string
        $data = json_decode($request->getContent(), true);
        $searchQuery = $data['searchTerm'] ?? null;


        // Find the event in database
        $user_id = $tokenStorage->getToken()->getUser()->getId();
        $eventRepository = $entityManager->getRepository(Event::class);

        try {
            $event = $eventRepository->findOneBy([
                'name' => $searchQuery,
                'user' => $user_id
            ]);
            if (!$event) {
                return new JsonResponse(['success' => false, 'error' => 'No event found']);
            }

            // Return the event information
            $eventArray = [
                'id' => $event->getId(),
                'name' => $event->getName(),
                'dateStart' => $event->getDateStart()->format(DateTime::ATOM),
                'dateEnd' => $event->getDateEnd()->format(DateTime::ATOM)
            ];


            return new JsonResponse(['success' => true, 'event' => $eventArray]);
        } catch (\Exception $e) {
            return new JsonResponse(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
