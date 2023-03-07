<?php



namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity('email', message : 'Cette adresse mail est déjà utilisée.')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Assert\NotBlank(message : 'Vous devez rentrer une adresse mail.')]
    #[Assert\Email(message:'Veuillez me donner une adresse mail valide.')]
    private ?string $email = null;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank(message : 'Le mot de passe ne peut pas être vide.')]
    #[Assert\Length(min: 12, max: 255, 
    minMessage: 'Le mot de passe doit contenir au moins {{ limit }} caractères.', 
    maxMessage: 'Le mot de passe ne peut pas dépasser {{ limit }} caractères.')]
    #[Assert\Regex(
        pattern: '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()\-_=+{};:,<.>�?~])/x',
        message: 'Veuillez relire les conditions correctes de création de  mot de passe.'
    )]
    #[Assert\IdenticalTo(propertyPath: "password", 
        message: 'Les mots de passe ne correspondent pas.'
    )]
    private ?string $password = null;

    #[ORM\Column(type: 'string', length: 200, nullable: true)]
    #[Assert\NotBlank(message: 'Le prénom ne peut pas être vide.')]
    private ?string $firstName = null;

    #[ORM\Column(type: 'string', length: 200)]
    #[Assert\NotBlank(message:'Le nom ne peut pas être vide.')]
    private ?string $lastName = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $profileImage = null;

    #[ORM\OneToMany(mappedBy: 'userId', targetEntity: Consent::class, cascade: ["persist"])]
    private Collection $consents;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Event::class)]
    private Collection $events;

    public function __construct()
    {
        $this->consents = new ArrayCollection();
        $this->roles[] = 'ROLE_USER';
        $this->events = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }
    

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getProfileImage(): ?string
    {
        return $this->profileImage;
    }

    public function setProfileImage(?string $profileImage): self
    {
        $this->profileImage = $profileImage;

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
            $this->consents[] = $consent;
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

    
}
