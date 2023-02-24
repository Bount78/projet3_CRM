<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[UniqueEntity('email', message: 'Cet email est déjà utilisé.')]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $profile_image = null;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $isAdmin = false;
    

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: Contact::class)]
    private Collection $contacts;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: Event::class)]
    private Collection $events;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: Calendar::class)]
    private Collection $calendars;

    #[ORM\OneToMany(mappedBy: 'userId', targetEntity: Consent::class)]
    private Collection $consents;

    #[ORM\ManyToMany(targetEntity: Rolepermission::class, mappedBy: 'userId')]
    private Collection $rolepermissionss;



    public function __construct()
    {
        $this->contacts = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->calendars = new ArrayCollection();
        $this->consents = new ArrayCollection();
        $this->rolepermissionss = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getProfileImage(): ?string
    {
        return $this->profile_image;
    }

    public function setProfileImage(?string $profile_image): self
    {
        $this->profile_image = $profile_image;

        return $this;
    }

    /**
     * @return Collection<int, Contact>
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
            $contact->setUserId($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getUserId() === $this) {
                $contact->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
            $event->setUserId($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getUserId() === $this) {
                $event->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Calendar>
     */
    public function getCalendars(): Collection
    {
        return $this->calendars;
    }

    public function addCalendar(Calendar $calendar): self
    {
        if (!$this->calendars->contains($calendar)) {
            $this->calendars->add($calendar);
            $calendar->setUserId($this);
        }

        return $this;
    }

    public function removeCalendar(Calendar $calendar): self
    {
        if ($this->calendars->removeElement($calendar)) {
            // set the owning side to null (unless already changed)
            if ($calendar->getUserId() === $this) {
                $calendar->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Consent>
     */
    public function getConsents(): Collection
    {
        return $this->consents;
    }

    public function addConsent(Consent $consent): self
    {
        if (!$this->consents->contains($consent)) {
            $this->consents->add($consent);
            $consent->setUserId($this);
        }

        return $this;
    }

    public function removeConsent(Consent $consent): self
    {
        if ($this->consents->removeElement($consent)) {
            // set the owning side to null (unless already changed)
            if ($consent->getUserId() === $this) {
                $consent->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Rolepermission>
     */

    /**
     * @return Collection<int, Rolepermission>
     */
    public function getRolepermissionss(): Collection
    {
        return $this->rolepermissionss;
    }

    public function addRolepermissionss(Rolepermission $rolepermissionss): self
    {
        if (!$this->rolepermissionss->contains($rolepermissionss)) {
            $this->rolepermissionss->add($rolepermissionss);
            $rolepermissionss->addUserId($this);
        }

        return $this;
    }

    public function removeRolepermissionss(Rolepermission $rolepermissionss): self
    {
        if ($this->rolepermissionss->removeElement($rolepermissionss)) {
            $rolepermissionss->removeUserId($this);
        }

        return $this;
    }




    /**
     * Get the value of isAdmin
     */ 
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * Set the value of isAdmin
     *
     * @return  self
     */ 
    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }
}
