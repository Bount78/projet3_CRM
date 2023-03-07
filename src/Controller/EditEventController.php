<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class EditEventController extends AbstractController
{
    #[Route('/event/edit', name: 'edit_event', methods: ['PUT'])]
    public function editEvent(Request $request, EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage): Response
    {
        // Récupérer l'ID de l'événement à éditer
        $eventId = $request->query->get('eventId');
        // Trouver l'événement en base de données
        $event = $entityManager->getRepository(Event::class)->find($eventId);

        // Vérifier que l'utilisateur est bien propriétaire de l'événement
        $user = $tokenStorage->getToken()->getUser();
        if ($event->getUserId() !== $user) {
            throw $this->createNotFoundException('Cet événement n\'existe pas');
        }

        // Récupérer les données du formulaire
        $eventName = $request->request->get('eventName');
        $eventStartTimestamp = $request->request->get('eventStart');
        $eventEndTimestamp = $request->request->get('eventEnd');

        // Convertir les timestamps en objets DateTime
        $eventStart = (new DateTime())->setTimestamp($eventStartTimestamp);
        $eventEnd = (new DateTime())->setTimestamp($eventEndTimestamp);

        // Mettre à jour l'objet Event
        $event->setName($eventName)
            ->setDateStart($eventStart)
            ->setDateEnd($eventEnd);

        // Persister l'objet en base de données
        $entityManager->flush();

        // Retourner les informations de l'événement modifié
        $eventArray = [
            'id' => $event->getId(),
            'name' => $event->getName(),
            'dateStart' => $event->getDateStart()->format(DateTime::ATOM),
            'dateEnd' => $event->getDateEnd()->format(DateTime::ATOM)
        ];

        return $this->json(['success' => true, 'event' => $eventArray]);
    }

    #[Route('/event/search', name: 'search_event')]
    public function searchEvent(Request $request, EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage): JsonResponse
    {
        // Récupérer la chaîne de recherche
        $searchQuery = $request->request->get('searchTerm');

        // Trouver l'événement en base de données
        $user_id = $tokenStorage->getToken()->getUser();
        $eventRepository = $entityManager->getRepository(Event::class);

        try {
            $event = $eventRepository->findOneBy([
                'name' => $searchQuery,
                'user' => $user_id
            ]);
            
            if (!$event) {
                return new JsonResponse(['success' => false, 'error' => 'No event found']);
            }

            // Retourner les informations de l'événement
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