<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: PanierRepository::class)]
class Panier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['panier'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['panier'])]
    private ?int $QuantitéP = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['panier'])]
    private ?\DateTimeInterface $CreationPanier = null;

    #[ORM\ManyToOne(inversedBy: 'paniers')]
    #[Ignore] // Prevent circular reference during serialization
    private ?comptes $NumCompte = null;

    #[ORM\ManyToOne(inversedBy: 'paniers')]
    private ?boisson $num_produit = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->QuantitéP;
    }

    public function setQuantity(int $QuantitéP): static
    {
        $this->QuantitéP = $QuantitéP;

        return $this;
    }

    public function getCreationPanier(): ?\DateTimeInterface
    {
        return $this->CreationPanier;
    }

    public function setCreationPanier(\DateTimeInterface $CreationPanier): static
    {
        $this->CreationPanier = $CreationPanier;

        return $this;
    }

    public function getNumCompte(): ?comptes
    {
        return $this->NumCompte;
    }

    public function setNumCompte(?comptes $NumCompte): static
    {
        $this->NumCompte = $NumCompte;

        return $this;
    }

    public function getNumProduit(): ?boisson
    {
        return $this->num_produit;
    }

    public function setNumProduit(?boisson $num_produit): static
    {
        $this->num_produit = $num_produit;

        return $this;
    }
}
