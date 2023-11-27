<?php

namespace App\Entity;

use App\Repository\TarifRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TarifRepository::class)]
class Tarif
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $montant = null;

    #[ORM\ManyToOne(inversedBy: 'tarifs')]
    private ?TypeCours $idTypeCours = null;

    #[ORM\ManyToOne(inversedBy: 'tarifs')]
    private ?Tranche $idTranche = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(?int $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getIdTypeCours(): ?TypeCours
    {
        return $this->idTypeCours;
    }

    public function setIdTypeCours(?TypeCours $idTypeCours): static
    {
        $this->idTypeCours = $idTypeCours;

        return $this;
    }

    public function getIdTranche(): ?Tranche
    {
        return $this->idTranche;
    }

    public function setIdTranche(?Tranche $idTranche): static
    {
        $this->idTranche = $idTranche;

        return $this;
    }
}
