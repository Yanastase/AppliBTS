<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: RoleRepository::class)]
class Role
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['role:read', 'compte:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['role:read', 'compte:read'])]
    private ?string $Role = null;

    /**
     * @var Collection<int, Comptes>
     */
    #[ORM\OneToMany(targetEntity: Comptes::class, mappedBy: 'NumRole')]
    #[Groups(['role:read'])]
    private Collection $comptes;

    public function __construct()
    {
        $this->comptes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRole(): ?string
    {
        return $this->Role;
    }

    public function setRole(string $Role): static
    {
        $this->Role = $Role;

        return $this;
    }

    /**
     * @return Collection<int, Comptes>
     */
    public function getComptes(): Collection
    {
        return $this->comptes;
    }

    public function addCompte(Comptes $compte): static
    {
        if (!$this->comptes->contains($compte)) {
            $this->comptes->add($compte);
            $compte->setNumRole($this);
        }

        return $this;
    }

    public function removeCompte(Comptes $compte): static
    {
        if ($this->comptes->removeElement($compte)) {
            // set the owning side to null (unless already changed)
            if ($compte->getNumRole() === $this) {
                $compte->setNumRole(null);
            }
        }

        return $this;
    }
}
