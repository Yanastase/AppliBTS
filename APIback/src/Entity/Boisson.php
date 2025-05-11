<?php

namespace App\Entity;

use App\Repository\BoissonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BoissonRepository::class)]
class Boisson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $Nom = null;

    #[ORM\Column(length: 80)]
    private ?string $Logo = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $DateProduction = null;

    #[ORM\ManyToOne(inversedBy: 'boissons')]
    private ?Alcools $NumAlcool = null;

    /**
     * @var Collection<int, Stocks>
     */
    #[ORM\OneToMany(targetEntity: Stocks::class, mappedBy: 'NumBoisson')]
    private Collection $stocks;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0)]
    private ?string $prix = null;

    /**
     * @var Collection<int, Panier>
     */
    #[ORM\OneToMany(targetEntity: Panier::class, mappedBy: 'num_produit')]
    private Collection $paniers;

    public function __construct()
    {
        $this->stocks = new ArrayCollection();
        $this->paniers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): static
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->Logo;
    }

    public function setLogo(string $Logo): static
    {
        $this->Logo = $Logo;

        return $this;
    }

    public function getDateProduction(): ?string
    {
        return $this->DateProduction;
    }

    public function setDateProduction(string $DateProduction): static
    {
        $this->DateProduction = $DateProduction;

        return $this;
    }

    public function getNumAlcool(): ?Alcools
    {
        return $this->NumAlcool;
    }

    public function setNumAlcool(?Alcools $NumAlcool): static
    {
        $this->NumAlcool = $NumAlcool;

        return $this;
    }

    /**
     * @return Collection<int, Stocks>
     */
    public function getStocks(): Collection
    {
        return $this->stocks;
    }

    public function addStock(Stocks $stock): static
    {
        if (!$this->stocks->contains($stock)) {
            $this->stocks->add($stock);
            $stock->setNumBoisson($this);
        }

        return $this;
    }

    public function removeStock(Stocks $stock): static
    {
        if ($this->stocks->removeElement($stock)) {
            // set the owning side to null (unless already changed)
            if ($stock->getNumBoisson() === $this) {
                $stock->setNumBoisson(null);
            }
        }

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): static
    {
        $this->prix = $prix;

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
            $panier->setNumProduit($this);
        }

        return $this;
    }

    public function removePanier(Panier $panier): static
    {
        if ($this->paniers->removeElement($panier)) {
            // set the owning side to null (unless already changed)
            if ($panier->getNumProduit() === $this) {
                $panier->setNumProduit(null);
            }
        }

        return $this;
    }
}
