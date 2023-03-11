<?php

namespace App\Entity;

use App\Repository\ConsentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConsentRepository::class)]
class Consent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $finalite = "accepte la politique de confidentialité.";

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'boolean')]
    private ?bool $accept = false;

    #[ORM\Column(type: 'datetime', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeInterface $date_consenti = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'consents')]
    #[ORM\JoinColumn(name: 'user_id_id', referencedColumnName: 'id', onDelete: 'SET NULL')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFinalite(): ?string
    {
        return $this->finalite;
    }

    public function setFinalite(?string $finalite): self
    {
        $this->finalite = $finalite ?? "accepte la politique de confidentialité.";

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

    public function getDateConsenti(): ?\DateTimeInterface
    {
        return $this->date_consenti;
    }

    public function setDateConsenti(?\DateTimeInterface $date_consenti): self
    {
        $this->date_consenti = $date_consenti;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
