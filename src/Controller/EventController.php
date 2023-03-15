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

class EventController extends AbstractController
{
    #[Route('/event', name: 'app_event')]
    public function addEvent(Request $request, EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage): Response
    {
        // Retrieve data from the form
        $eventName = $request->request->get('eventName');
        $eventStartTimestamp = $request->request->get('eventStart');
        $eventEndTimestamp = $request->request->get('eventEnd');

        //Get the connected user from the session
        $user = $tokenStorage->getToken()->getUser();
        // Convert timestamps to DateTime objects
        $eventStart = (new DateTime())->setTimestamp($eventStartTimestamp);
        $eventEnd = (new DateTime())->setTimestamp($eventEndTimestamp);

        // Create a new Event object
        $event = new Event();
        $event->setName($eventName)
            ->setDateStart($eventStart)
            ->setDateEnd($eventEnd)
            ->setUserId($user);

        // Persist object in database
        $entityManager->persist($event);
        $entityManager->flush();

        // Add Event to Calendar
        $eventArray = [
            'id' => $event->getId(),
            'title' => $event->getName(),
            'start' => $event->getDateStart()->format(DateTime::ATOM),
            'end' => $event->getDateEnd()->format(DateTime::ATOM)
        ];

        return $this->json(['success' => true, 'event' => $eventArray]);
    }

    #[Route('/events', name: 'app_events')]
    public function getEvents(EventRepository $eventRepository): JsonResponse
    {
        $events = $eventRepository->findAll();
        $eventArray = array();
        foreach ($events as $event) {
            $eventArray[] = [
                'id' => $event->getId(),
                'title' => $event->getName(),
                'start' => $event->getDateStart()->format(DateTime::ATOM),
                'end' => $event->getDateEnd()->format(DateTime::ATOM)
            ];
        }

        return $this->json($eventArray);
    }
}
