<?php

namespace App\Entity;

use App\Repository\InstrumentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InstrumentRepository::class)]
class Instrument
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $numSerie = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateAchat = null;

    #[ORM\Column(nullable: true)]
    private ?int $prixAchat = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $utilisation = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $cheminImage = null;

    #[ORM\ManyToOne(inversedBy: 'idInstrument')]
    private ?Marque $marque = null;

    #[ORM\ManyToOne(inversedBy: 'instruments')]
    private ?TypeInstrument $idTypeInstrument = null;

    #[ORM\OneToMany(mappedBy: 'instrument', targetEntity: ContratPrêt::class)]
    private Collection $idContratPret;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $idCouleurt = null;

    #[ORM\ManyToMany(targetEntity: Couleur::class, inversedBy: 'instruments')]
    private Collection $idCouleur;

    #[ORM\OneToMany(mappedBy: 'instrument', targetEntity: Accessoire::class)]
    private Collection $idAccessoire;

    #[ORM\OneToMany(mappedBy: 'instrument', targetEntity: Intervention::class)]
    private Collection $idIntervention;

    public function __construct()
    {
        $this->idContratPret = new ArrayCollection();
        $this->idCouleur = new ArrayCollection();
        $this->idAccessoire = new ArrayCollection();
        $this->idIntervention = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumSerie(): ?string
    {
        return $this->numSerie;
    }

    public function setNumSerie(string $numSerie): static
    {
        $this->numSerie = $numSerie;

        return $this;
    }

    public function getDateAchat(): ?\DateTimeInterface
    {
        return $this->dateAchat;
    }

    public function setDateAchat(?\DateTimeInterface $dateAchat): static
    {
        $this->dateAchat = $dateAchat;

        return $this;
    }

    public function getPrixAchat(): ?int
    {
        return $this->prixAchat;
    }

    public function setPrixAchat(?int $prixAchat): static
    {
        $this->prixAchat = $prixAchat;

        return $this;
    }

    public function getUtilisation(): ?string
    {
        return $this->utilisation;
    }

    public function setUtilisation(?string $utilisation): static
    {
        $this->utilisation = $utilisation;

        return $this;
    }

    public function getCheminImage(): ?string
    {
        return $this->cheminImage;
    }

    public function setCheminImage(?string $cheminImage): static
    {
        $this->cheminImage = $cheminImage;

        return $this;
    }

    public function getMarque(): ?Marque
    {
        return $this->marque;
    }

    public function setMarque(?Marque $marque): static
    {
        $this->marque = $marque;

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

    /**
     * @return Collection<int, ContratPrêt>
     */
    public function getIdContratPret(): Collection
    {
        return $this->idContratPret;
    }

    public function addIdContratPret(ContratPrêt $idContratPret): static
    {
        if (!$this->idContratPret->contains($idContratPret)) {
            $this->idContratPret->add($idContratPret);
            $idContratPret->setInstrument($this);
        }

        return $this;
    }

    public function removeIdContratPret(ContratPrêt $idContratPret): static
    {
        if ($this->idContratPret->removeElement($idContratPret)) {
            // set the owning side to null (unless already changed)
            if ($idContratPret->getInstrument() === $this) {
                $idContratPret->setInstrument(null);
            }
        }

        return $this;
    }

    public function getIdCouleurt(): ?string
    {
        return $this->idCouleurt;
    }

    public function setIdCouleurt(?string $idCouleurt): static
    {
        $this->idCouleurt = $idCouleurt;

        return $this;
    }

    /**
     * @return Collection<int, Couleur>
     */
    public function getIdCouleur(): Collection
    {
        return $this->idCouleur;
    }

    public function addIdCouleur(Couleur $idCouleur): static
    {
        if (!$this->idCouleur->contains($idCouleur)) {
            $this->idCouleur->add($idCouleur);
        }

        return $this;
    }

    public function removeIdCouleur(Couleur $idCouleur): static
    {
        $this->idCouleur->removeElement($idCouleur);

        return $this;
    }

    /**
     * @return Collection<int, Accessoire>
     */
    public function getIdAccessoire(): Collection
    {
        return $this->idAccessoire;
    }

    public function addIdAccessoire(Accessoire $idAccessoire): static
    {
        if (!$this->idAccessoire->contains($idAccessoire)) {
            $this->idAccessoire->add($idAccessoire);
            $idAccessoire->setInstrument($this);
        }

        return $this;
    }

    public function removeIdAccessoire(Accessoire $idAccessoire): static
    {
        if ($this->idAccessoire->removeElement($idAccessoire)) {
            // set the owning side to null (unless already changed)
            if ($idAccessoire->getInstrument() === $this) {
                $idAccessoire->setInstrument(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Intervention>
     */
    public function getIdIntervention(): Collection
    {
        return $this->idIntervention;
    }

    public function addIdIntervention(Intervention $idIntervention): static
    {
        if (!$this->idIntervention->contains($idIntervention)) {
            $this->idIntervention->add($idIntervention);
            $idIntervention->setInstrument($this);
        }

        return $this;
    }

    public function removeIdIntervention(Intervention $idIntervention): static
    {
        if ($this->idIntervention->removeElement($idIntervention)) {
            // set the owning side to null (unless already changed)
            if ($idIntervention->getInstrument() === $this) {
                $idIntervention->setInstrument(null);
            }
        }

        return $this;
    }
}
