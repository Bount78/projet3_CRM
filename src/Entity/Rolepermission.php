<?php

namespace App\Entity;

use App\Repository\RolepermissionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RolepermissionRepository::class)]
class Rolepermission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: user::class, inversedBy: 'rolepermissionss')]
    private Collection $userId;

    #[ORM\ManyToMany(targetEntity: permission::class, inversedBy: 'rolepermissions')]
    private Collection $permissionId;

    public function __construct()
    {
        $this->userId = new ArrayCollection();
        $this->permissionId = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, user>
     */
    public function getUserId(): Collection
    {
        return $this->userId;
    }

    public function addUserId(user $userId): self
    {
        if (!$this->userId->contains($userId)) {
            $this->userId->add($userId);
        }

        return $this;
    }

    public function removeUserId(user $userId): self
    {
        $this->userId->removeElement($userId);

        return $this;
    }

    /**
     * @return Collection<int, permission>
     */
    public function getPermissionId(): Collection
    {
        return $this->permissionId;
    }

    public function addPermissionId(permission $permissionId): self
    {
        if (!$this->permissionId->contains($permissionId)) {
            $this->permissionId->add($permissionId);
        }

        return $this;
    }

    public function removePermissionId(permission $permissionId): self
    {
        $this->permissionId->removeElement($permissionId);

        return $this;
    }


}
