<?php

namespace App\Entity;

use App\Repository\ContratPretRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContratPretRepository::class)]
class ContratPret
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\Expression("this.getDateDebut() < this.getDateFin()", message: 'je ne fonctionne pas')]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column(length: 25)]
    private ?string $attestationAssurance = null;

    #[ORM\Column(length: 255)]
    private ?string $etatDetailleDebut = null;

    #[ORM\Column(length: 255)]
    private ?string $etatDetailleRetour = null;

    #[ORM\ManyToOne(inversedBy: 'contratsPret')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Eleve $eleve = null;

    #[ORM\OneToMany(mappedBy: 'contratPret', targetEntity: InterPret::class, orphanRemoval: true)]
    private Collection $interPrets;

    public function __construct()
    {
        $this->interPrets = new ArrayCollection();
    }

    #[ORM\ManyToOne(inversedBy: 'ContratsPret')]
    private ?Instrument $instrument = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getAttestationAssurance(): ?string
    {
        return $this->attestationAssurance;
    }

    public function setAttestationAssurance(string $attestationAssurance): static
    {
        $this->attestationAssurance = $attestationAssurance;

        return $this;
    }

    public function getEtatDetailleDebut(): ?string
    {
        return $this->etatDetailleDebut;
    }

    public function setEtatDetailleDebut(string $etatDetailleDebut): static
    {
        $this->etatDetailleDebut = $etatDetailleDebut;

        return $this;
    }

    public function getEtatDetailleRetour(): ?string
    {
        return $this->etatDetailleRetour;
    }

    public function setEtatDetailleRetour(string $etatDetailleRetour): static
    {
        $this->etatDetailleRetour = $etatDetailleRetour;

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

    public function getInstrument(): ?Instrument
    {
        return $this->instrument;
    }

    public function setInstrument(?Instrument $instrument): static
    {
        $this->instrument = $instrument;

        return $this;
    }

    /**
     * @return Collection<int, InterPret>
     */
    public function getInterPrets(): Collection
    {
        return $this->interPrets;
    }

    public function addInterPret(InterPret $interPret): static
    {
        if (!$this->interPrets->contains($interPret)) {
            $this->interPrets->add($interPret);
            $interPret->setIntervention($this);
        }

        return $this;
    }

    public function removeInterPret(InterPret $interPret): static
    {
        if ($this->interPrets->removeElement($interPret)) {
            // set the owning side to null (unless already changed)
            if ($interPret->getIntervention() === $this) {
                $interPret->setIntervention(null);
            }
        }

        return $this;
    }
}
