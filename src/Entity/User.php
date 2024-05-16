<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
 * @var Collection<int, Panier>
 */
#[ORM\OneToMany(targetEntity: Panier::class, mappedBy: 'user', cascade: ['persist', 'remove'])]
private Collection $paniers;


    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    /**
     * @var Collection<int, Enfant>
     */
    #[ORM\ManyToMany(targetEntity: Enfant::class, inversedBy: 'users')]
    private Collection $aimer;

    /**
     * @var Collection<int, Femme>
     */
    #[ORM\ManyToMany(targetEntity: Femme::class, inversedBy: 'users')]
    private Collection $aimerFemme;

    /**
     * @var Collection<int, Homme>
     */
    #[ORM\ManyToMany(targetEntity: Homme::class, inversedBy: 'users')]
    private Collection $aimerHomme;

    public function __construct()
    {
        $this->aimer = new ArrayCollection();
        $this->aimerFemme = new ArrayCollection();
        $this->aimerHomme = new ArrayCollection();
        $this->ajouterNom = new ArrayCollection();
        $this->ajouterPrix = new ArrayCollection();
        $this->ajouterImage = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
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
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
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

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Enfant>
     */
    public function getAimer(): Collection
    {
        return $this->aimer;
    }

    public function addAimer(Enfant $aimer): static
    {
        if (!$this->aimer->contains($aimer)) {
            $this->aimer->add($aimer);
        }

        return $this;
    }

    public function removeAimer(Enfant $aimer): static
    {
        $this->aimer->removeElement($aimer);

        return $this;
    }

    /**
     * @return Collection<int, Femme>
     */
    public function getAimerFemme(): Collection
    {
        return $this->aimerFemme;
    }

    public function addAimerFemme(Femme $aimerFemme): static
    {
        if (!$this->aimerFemme->contains($aimerFemme)) {
            $this->aimerFemme->add($aimerFemme);
        }

        return $this;
    }

    public function removeAimerFemme(Femme $aimerFemme): static
    {
        $this->aimerFemme->removeElement($aimerFemme);

        return $this;
    }

    /**
     * @return Collection<int, Homme>
     */
    public function getAimerHomme(): Collection
    {
        return $this->aimerHomme;
    }

    public function addAimerHomme(Homme $aimerHomme): static
    {
        if (!$this->aimerHomme->contains($aimerHomme)) {
            $this->aimerHomme->add($aimerHomme);
        }

        return $this;
    }

    public function removeAimerHomme(Homme $aimerHomme): static
    {
        $this->aimerHomme->removeElement($aimerHomme);

        return $this;
    }



    public function getPaniers(): Collection
    {
        return $this->paniers;
    }

    public function addPanier(Panier $paniers): static
    {
        if (!$this->paniers->contains($paniers)) {
            $this->paniers->add($paniers);
        }
        return $this;
    }


    public function removePanier(Panier $paniers): static
    {
        if($this->paniers->removeElement($paniers)) {
            if($panier->getUser() === $this) {
                $panier->setUser(null);
            }
        };

        return $this;
    }


}
