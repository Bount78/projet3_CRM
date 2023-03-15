<?php

namespace App\Controller;

use App\Entity\Event;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class DeleteEventController extends AbstractController
{

    #[Route('/event/searchDelete', name: 'search_delete_event')]
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


    #[Route('/event/{id}', name: 'delete_event', methods: ['DELETE'])]
    public function deleteEvent(Request $request, EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage, int $id): JsonResponse
    {
        // Retrieve the logged in user
        $user = $tokenStorage->getToken()->getUser();
    
        // Retrieve the event to be deleted
        $eventRepository = $entityManager->getRepository(Event::class);
        $event = $eventRepository->findOneBy(['id' => $id, 'user' => $user]);
    
        if (!$event) {
            return new JsonResponse(['success' => false, 'error' => 'No event found']);
        }
    
        // Verify that the user confirmation has been received
        $data = json_decode($request->getContent(), true);
        $confirmed = $data['confirmed'] ?? false;
    
        if (!$confirmed) {
            return new JsonResponse(['success' => false, 'error' => 'Confirmation required']);
        }
    
        // Delete event
        try {
            $entityManager->remove($event);
            $entityManager->flush();
    
            return new JsonResponse(['success' => true]);
        } catch (\Exception $e) {
            return new JsonResponse(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    
}
