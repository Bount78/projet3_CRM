<?php

namespace App\Entity;

use App\Repository\ConsentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConsentRepository::class)]
class Consent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 255)]
    private ?string $finalite = "accepte la polique de confidentialité.";

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $accept = false;

    
     #[ORM\Column(type: 'datetime', nullable: true, options: ['default' => 'CURRENT_TIMESTAMP'])]
     
    private $date_consenti;

    #[ORM\ManyToOne(targetEntity: 'App\Entity\User', inversedBy: 'consents')]
    #[ORM\JoinColumn(nullable: false)]
    private $userId;

    public function __toString(): string
    {
        return (string) $this->getId();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getFinalite(): ?string
    {
        return $this->finalite;
    }

    public function setFinalite(string $finalite): self
    {
        $this->finalite = $finalite;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function isAccept(): ?bool
    {
        return $this->accept;
    }

    public function setAccept(bool $accept): self
    {
        $this->accept = $accept;

        return $this;
    }

    public function getDateConsenti(): ?\DateTimeImmutable
    {
        return $this->date_consenti;
    }

    public function setDateConsenti(\DateTimeImmutable $date_consenti): self
    {
        $this->date_consenti = $date_consenti;

        return $this;
    }

    public function getUserId(): ?user
    {
        return $this->userId;
    }

    public function setUserId(?user $userId): self
    {
        $this->userId = $userId;

        return $this;
    }
}
