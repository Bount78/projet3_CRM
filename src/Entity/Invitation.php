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
    private ?event $event_id = null;

    #[ORM\ManyToOne(inversedBy: 'invitations')]
    private ?contact $contactId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEventId(): ?event
    {
        return $this->event_id;
    }

    public function setEventId(?event $event_id): self
    {
        $this->event_id = $event_id;

        return $this;
    }

    public function getContactId(): ?contact
    {
        return $this->contactId;
    }

    public function setContactId(?contact $contactId): self
    {
        $this->contactId = $contactId;

        return $this;
    }
}
