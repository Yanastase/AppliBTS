<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AlcoolsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AlcoolsRepository::class)]
#[ApiResource]
class Alcools
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $NomAlcool = null;

    /**
     * @var Collection<int, Boisson>
     */
    #[ORM\OneToMany(targetEntity: Boisson::class, mappedBy: 'NumAlcool')]
    private Collection $boissons;

    public function __construct()
    {
        $this->boissons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomAlcool(): ?string
    {
        return $this->NomAlcool;
    }

    public function setNomAlcool(string $NomAlcool): static
    {
        $this->NomAlcool = $NomAlcool;

        return $this;
    }

    /**
     * @return Collection<int, Boisson>
     */
    public function getBoissons(): Collection
    {
        return $this->boissons;
    }

    public function addBoisson(Boisson $boisson): static
    {
        if (!$this->boissons->contains($boisson)) {
            $this->boissons->add($boisson);
            $boisson->setNumAlcool($this);
        }

        return $this;
    }

    public function removeBoisson(Boisson $boisson): static
    {
        if ($this->boissons->removeElement($boisson)) {
            // set the owning side to null (unless already changed)
            if ($boisson->getNumAlcool() === $this) {
                $boisson->setNumAlcool(null);
            }
        }

        return $this;
    }
}
