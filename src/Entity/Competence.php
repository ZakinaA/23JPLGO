<?php

namespace App\Entity;

use App\Repository\CompetenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompetenceRepository::class)]
class Competence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $code = null;

    #[ORM\Column(length: 50)]
    private ?string $libelle = null;

    #[ORM\Column(length: 20)]
    private ?string $nbEtudiantsMax = null;

    #[ORM\ManyToMany(targetEntity: Professeur::class, inversedBy: 'competences')]
    private Collection $professeurs;

    #[ORM\ManyToOne(inversedBy: 'competences')]
    private ?Note $notes = null;

    public function __construct()
    {
        $this->professeurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getNbEtudiantsMax(): ?string
    {
        return $this->nbEtudiantsMax;
    }

    public function setNbEtudiantsMax(string $nbEtudiantsMax): static
    {
        $this->nbEtudiantsMax = $nbEtudiantsMax;

        return $this;
    }

    /**
     * @return Collection<int, Professeur>
     */
    public function getProfesseurs(): Collection
    {
        return $this->professeurs;
    }

    public function addProfesseur(Professeur $professeur): static
    {
        if (!$this->professeurs->contains($professeur)) {
            $this->professeurs->add($professeur);
        }

        return $this;
    }

    public function removeProfesseur(Professeur $professeur): static
    {
        $this->professeurs->removeElement($professeur);

        return $this;
    }

    public function getNotes(): ?Note
    {
        return $this->notes;
    }

    public function setNotes(?Note $notes): static
    {
        $this->notes = $notes;

        return $this;
    }
}
