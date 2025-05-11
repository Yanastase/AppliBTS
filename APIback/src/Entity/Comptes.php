<?php

namespace App\Entity;

use App\Repository\ComptesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ComptesRepository::class)]
class Comptes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['compte:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['compte:read', 'compte:write'])]
    private ?string $identifiant = null;

    #[ORM\Column(length: 255)]
    #[Groups(['compte:write'])]
    private ?string $MotDePasse = null;

    #[ORM\Column(length: 255)]
    #[Groups(['compte:read', 'compte:write'])]
    private ?string $Email = null;

    #[ORM\Column(length: 255)]
    #[Groups(['compte:read', 'compte:write'])]
    private ?string $NumTel = null;

    #[ORM\ManyToOne(inversedBy: 'comptes')]
    #[Groups(['compte:read', 'compte:write'])]
    private ?Role $NumRole = null;

    /**
     * @var Collection<int, Panier>
     */
    #[ORM\OneToMany(targetEntity: Panier::class, mappedBy: 'NumCompte')]
    private Collection $paniers;

    public function __construct()
    {
        $this->paniers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdentifiant(): ?string
    {
        return $this->identifiant;
    }

    public function setIdentifiant(string $identifiant): static
    {
        $this->identifiant = $identifiant;

        return $this;
    }

    public function getMotDePasse(): ?string
    {
        return $this->MotDePasse;
    }

    public function setMotDePasse(string $MotDePasse): static
    {
        $this->MotDePasse = $MotDePasse;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): static
    {
        $this->Email = $Email;

        return $this;
    }

    public function getNumTel(): ?string
    {
        return $this->NumTel;
    }

    public function setNumTel(string $NumTel): static
    {
        $this->NumTel = $NumTel;

        return $this;
    }

    public function getNumRole(): ?Role
    {
        return $this->NumRole;
    }

    public function setNumRole(?Role $NumRole): static
    {
        $this->NumRole = $NumRole;

        return $this;
    }

    /**
     * @return Collection<int, Panier>
     */
    public function getPaniers(): Collection
    {
        return $this->paniers;
    }

    public function addPanier(Panier $panier): static
    {
        if (!$this->paniers->contains($panier)) {
            $this->paniers->add($panier);
            $panier->setNumCompte($this);
        }

        return $this;
    }

    public function removePanier(Panier $panier): static
    {
        if ($this->paniers->removeElement($panier)) {
            // set the owning side to null (unless already changed)
            if ($panier->getNumCompte() === $this) {
                $panier->setNumCompte(null);
            }
        }

        return $this;
    }
}
