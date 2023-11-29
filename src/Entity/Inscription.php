<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InscriptionRepository::class)]
class Inscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateInscription = null;

    #[ORM\ManyToOne(inversedBy: 'inscriptions')]
    private ?Eleve $eleve = null;

    #[ORM\ManyToOne(inversedBy: 'inscriptions')]
    private ?Cours $idCours = null;

    #[ORM\OneToMany(mappedBy: 'inscription', targetEntity: Paiement::class)]
    private Collection $idPaiement;

    public function __construct()
    {
        $this->idPaiement = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->dateInscription;
    }

    public function setDateInscription(?\DateTimeInterface $dateInscription): static
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    public function getEleve(): ?Eleve
    {
        return $this->eleve;
    }

    public function setEleve(?Eleve $eleve): static
    {
        $this->eleve = $eleve;

        return $this;
    }

    public function getIdCours(): ?Cours
    {
        return $this->idCours;
    }

    public function setIdCours(?Cours $idCours): static
    {
        $this->idCours = $idCours;

        return $this;
    }

    /**
     * @return Collection<int, Paiement>
     */
    public function getIdPaiement(): Collection
    {
        return $this->idPaiement;
    }

    public function addIdPaiement(Paiement $idPaiement): static
    {
        if (!$this->idPaiement->contains($idPaiement)) {
            $this->idPaiement->add($idPaiement);
            $idPaiement->setInscription($this);
        }

        return $this;
    }

    public function removeIdPaiement(Paiement $idPaiement): static
    {
        if ($this->idPaiement->removeElement($idPaiement)) {
            // set the owning side to null (unless already changed)
            if ($idPaiement->getInscription() === $this) {
                $idPaiement->setInscription(null);
            }
        }

        return $this;
    }
}
