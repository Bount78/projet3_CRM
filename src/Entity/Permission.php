<?php

namespace App\Entity;

use App\Repository\PermissionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PermissionRepository::class)]
class Permission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: Rolepermission::class, mappedBy: 'permissionId')]
    private Collection $rolepermissions;

    public function __construct()
    {
        $this->rolepermissions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    /**
     * @return Collection<int, Rolepermission>
     */
    public function getRolepermissions(): Collection
    {
        return $this->rolepermissions;
    }

    public function addRolepermission(Rolepermission $rolepermission): self
    {
        if (!$this->rolepermissions->contains($rolepermission)) {
            $this->rolepermissions->add($rolepermission);
            $rolepermission->addPermissionId($this);
        }

        return $this;
    }

    public function removeRolepermission(Rolepermission $rolepermission): self
    {
        if ($this->rolepermissions->removeElement($rolepermission)) {
            $rolepermission->removePermissionId($this);
        }

        return $this;
    }
}
