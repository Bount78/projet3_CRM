<?php

namespace App\Entity;

use App\Repository\InvitationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InvitationRepository::class)]
class Invitation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'invitations')]
    private ?Event $event_id = null;

    #[ORM\ManyToOne(inversedBy: 'invitations')]
    private ?Contact $contactId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEventId(): ?Event
    {
        return $this->event_id;
    }

    public function setEventId(?Event $event_id): self
    {
        $this->event_id = $event_id;

        return $this;
    }

    public function getContactId(): ?Contact
    {
        return $this->contactId;
    }

    public function setContactId(?Contact $contactId): self
    {
        $this->contactId = $contactId;

        return $this;
    }
}
