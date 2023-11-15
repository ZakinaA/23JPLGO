<?php

namespace App\Entity;

use App\Repository\CoursRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoursRepository::class)]
class Cours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $libelle = null;

    #[ORM\Column(nullable: true)]
    private ?int $ageMini = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $heureDebut = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $heureFin = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbPlaces = null;

    #[ORM\Column(nullable: true)]
    private ?int $ageMaxi = null;

    #[ORM\ManyToOne(inversedBy: 'cours')]
    private ?Jour $idJour = null;

    #[ORM\ManyToOne(inversedBy: 'cours')]
    private ?TypeCours $idTypeCours = null;

    #[ORM\ManyToOne(inversedBy: 'cours')]
    private ?Professeur $idProfesseur = null;

    #[ORM\ManyToOne(inversedBy: 'cours')]
    private ?TypeInstrument $idTypeInstrument = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getAgeMini(): ?int
    {
        return $this->ageMini;
    }

    public function setAgeMini(?int $ageMini): static
    {
        $this->ageMini = $ageMini;

        return $this;
    }

    public function getHeureDebut(): ?\DateTimeInterface
    {
        return $this->heureDebut;
    }

    public function setHeureDebut(?\DateTimeInterface $heureDebut): static
    {
        $this->heureDebut = $heureDebut;

        return $this;
    }

    public function getHeureFin(): ?\DateTimeInterface
    {
        return $this->heureFin;
    }

    public function setHeureFin(?\DateTimeInterface $heureFin): static
    {
        $this->heureFin = $heureFin;

        return $this;
    }

    public function getNbPlaces(): ?int
    {
        return $this->nbPlaces;
    }

    public function setNbPlaces(?int $nbPlaces): static
    {
        $this->nbPlaces = $nbPlaces;

        return $this;
    }

    public function getAgeMaxi(): ?int
    {
        return $this->ageMaxi;
    }

    public function setAgeMaxi(?int $ageMaxi): static
    {
        $this->ageMaxi = $ageMaxi;

        return $this;
    }

    public function getIdJour(): ?Jour
    {
        return $this->idJour;
    }

    public function setIdJour(?Jour $idJour): static
    {
        $this->idJour = $idJour;

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

    public function getIdProfesseur(): ?Professeur
    {
        return $this->idProfesseur;
    }

    public function setIdProfesseur(?Professeur $idProfesseur): static
    {
        $this->idProfesseur = $idProfesseur;

        return $this;
    }

    public function getIdTypeInstrument(): ?TypeInstrument
    {
        return $this->idTypeInstrument;
    }

    public function setIdTypeInstrument(?TypeInstrument $idTypeInstrument): static
    {
        $this->idTypeInstrument = $idTypeInstrument;

        return $this;
    }
}
