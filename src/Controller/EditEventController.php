<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use DateTime;
use Symfony\Component\Security\Core\Security;
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
        $data = json_decode($request->getContent(), true);
        $searchQuery = $data['searchTerm'] ?? null;


        // Trouver l'événement en base de données
        $user_id = $tokenStorage->getToken()->getUser()->getId();
        $eventRepository = $entityManager->getRepository(Event::class);
        // var_dump($eventRepository);

        try {
            $event = $eventRepository->findOneBy([
                'name' => $searchQuery,
                'user' => $user_id
            ]);
            // dd($event);
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

    #[Route('/event/edit/{eventId}', name: 'update_event', methods: ['PUT'])]
    public function updateEvent(Request $request, EntityManagerInterface $entityManager, Security $security): JsonResponse
    {
        // Récupérer l'utilisateur connecté
        $user = $security->getUser();
    
        // Récupérer l'événement à éditer
        $eventId = $request->request->get('eventId');
        $event = $entityManager->getRepository(Event::class)->find($eventId);
    
        // Vérifier que l'utilisateur est bien propriétaire de l'événement
        if ($event->getUser() !== $user) {
            throw $this->createNotFoundException('Cet événement n\'existe pas');
        }
    
        // Récupérer les données du formulaire
        $eventName = $request->request->get('name');
        $eventStartTimestamp = $request->request->get('dateStart');
        $eventEndTimestamp = $request->request->get('datetEnd');
    
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
    
        return new JsonResponse(['success' => true, 'event' => $eventArray]);
    }
    

}
