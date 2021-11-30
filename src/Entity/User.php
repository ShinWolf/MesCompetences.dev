<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Annotation\ApiResource;
/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
#[ApiResource(normalizationContext:['groups' => ['read']], itemOperations: ["get", "patch"=>["security"=>"is_granted('ROLE_ADMIN') or object == user"]])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(["read"])]
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    #[Groups(["read"])]
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    #[Groups(["read"])]
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    #[Groups(["read"])]
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=Atribuer::class, mappedBy="user")
     */
    private $atribuers;

   
    public function __construct()
    {
        $this->atribuers = new ArrayCollection();
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
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
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
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Atribuer[]
     */
    public function getAtribuers(): Collection
    {
        return $this->atribuers;
    }

    public function addAtribuer(Atribuer $atribuer): self
    {
        if (!$this->atribuers->contains($atribuer)) {
            $this->atribuers[] = $atribuer;
            $atribuer->setUser($this);
        }

        return $this;
    }

    public function removeAtribuer(Atribuer $atribuer): self
    {
        if ($this->atribuers->removeElement($atribuer)) {
            // set the owning side to null (unless already changed)
            if ($atribuer->getUser() === $this) {
                $atribuer->setUser(null);
            }
        }

        return $this;
    }

  
}
