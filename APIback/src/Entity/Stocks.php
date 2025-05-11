<?php

namespace App\Entity;

use App\Repository\StocksRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StocksRepository::class)]
class Stocks
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $Quantité = null;

    #[ORM\ManyToOne(inversedBy: 'stocks')]
    private ?Boisson $NumBoisson = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantité(): ?int
    {
        return $this->Quantité;
    }

    public function setQuantité(int $Quantité): static
    {
        $this->Quantité = $Quantité;

        return $this;
    }

    

    

    public function getNumBoisson(): ?Boisson
    {
        return $this->NumBoisson;
    }

    public function setNumBoisson(?Boisson $NumBoisson): static
    {
        $this->NumBoisson = $NumBoisson;

        return $this;
    }
}
