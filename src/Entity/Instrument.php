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

    #[ORM\ManyToOne(inversedBy: 'instruments')]
    private ?Marque $marque = null;

    #[ORM\ManyToOne(inversedBy: 'instruments')]
    private ?TypeInstrument $typeInstrument = null;

    #[ORM\OneToMany(mappedBy: 'instrument', targetEntity: ContratPret::class)]
    private Collection $contratsPret;

    #[ORM\ManyToMany(targetEntity: Couleur::class, inversedBy: 'instruments')]
    private Collection $couleur;

    #[ORM\OneToMany(mappedBy: 'instrument', targetEntity: Accessoire::class)]
    private Collection $accessoires;

    #[ORM\OneToMany(mappedBy: 'instrument', targetEntity: Intervention::class)]
    private Collection $interventions;

    public function __construct()
    {
        $this->contratPret = new ArrayCollection();
        $this->couleur = new ArrayCollection();
        $this->accessoire = new ArrayCollection();
        $this->intervention = new ArrayCollection();
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

    public function getTypeInstrument(): ?TypeInstrument
    {
        return $this->typeInstrument;
    }

    public function setTypeInstrument(?TypeInstrument $typeInstrument): static
    {
        $this->typeInstrument = $typeInstrument;
        return $this;
    }

    /**
     * @return Collection<int, Couleur>
     */
  
    public function getCouleurs(): Collection
    {
        return $this->Couleurs;
    }

    public function addCouleur(Couleur $couleur): static
    {
        if (!$this->Couleurs->contains($couleur)) {
            $this->Couleurs->add($couleur);

    public function getContratPret(): Collection
    {
        return $this->contratPret;
    }

    public function addContratPret(ContratPret $contratPret): static
    {
        if (!$this->contratPret->contains($contratPret)) {
            $this->contratPret->add($contratPret);
            $contratPret->setInstrument($this);
        }

        return $this;
    }

    public function removeContratPret(ContratPret $contratPret): static
    {
        if ($this->contratPret->removeElement($contratPret)) {
            // set the owning side to null (unless already changed)
            if ($contratPret->getInstrument() === $this) {
                $contratPret->setInstrument(null);
            }

        }

        return $this;
    }

    public function removeCouleur(Couleur $couleur): static
    {
        $this->Couleurs->removeElement($couleur);

        return $this;
    }

    /**
     * @return Collection<int, Accessoire>
     */
    public function getAccessoires(): Collection
    {
        return $this->Accessoires;
    }

    public function addAccessoire(Accessoire $accessoire): static
    {
        if (!$this->Accessoires->contains($accessoire)) {
            $this->Accessoires->add($accessoire);
            $accessoire->setInstrument($this);
          
    /**
     * @return Collection<int, Accessoire>
     */
    public function getCouleur(): Collection
    {
        return $this->couleur;
    }

    public function addCouleur(Couleur $couleur): static
    {
        if (!$this->couleur->contains($couleur)) {
            $this->couleur->add($couleur);

        }

        return $this;
    }


    public function removeAccessoire(Accessoire $accessoire): static
    {
        if ($this->Accessoires->removeElement($accessoire)) {
            // set the owning side to null (unless already changed)
            if ($accessoire->getInstrument() === $this) {
                $accessoire->setInstrument(null);
            }
        }

    public function getIntervention(): Collection
    {
        return $this->Intervention;
    }

    public function addIntervention(Intervention $intervention): static
    {
        if (!$this->Intervention->contains($intervention)) {
            $this->Intervention->add($intervention);
            $intervention->setInstrument($this);

    public function getAccessoire(): Collection
    {
        return $this->accessoire;
    }

    public function addAccessoire(Accessoire $accessoire): static
    {
        if (!$this->accessoire->contains($accessoire)) {
            $this->accessoire->add($accessoire);
            $accessoire->setInstrument($this);
        }

        return $this;
    }


    public function removeAccessoire(Accessoire $accessoire): static
    {
        if ($this->accessoire->removeElement($accessoire)) {
            // set the owning side to null (unless already changed)
            if ($accessoire->getInstrument() === $this) {
                $accessoire->setInstrument(null);
            }
        }

        return $this;
    }


    public function addContratsPret(ContratPret $contratsPret): static
    {
        if (!$this->ContratsPret->contains($contratsPret)) {
            $this->ContratsPret->add($contratsPret);
            $contratsPret->setInstrument($this);

     * @return Collection<int, ContratPrêt>
     */
    public function getIntervention(): Collection
    {
        return $this->intervention;
    }

    public function addIntervention(Intervention $intervention): static
    {
        if (!$this->intervention->contains($intervention)) {
            $this->intervention->add($intervention);
            $intervention->setInstrument($this);
        }

        return $this;
    }


    public function removeContratsPret(ContratPret $contratsPret): static
    {
        if ($this->ContratsPret->removeElement($contratsPret)) {
            // set the owning side to null (unless already changed)
            if ($contratsPret->getInstrument() === $this) {
                $contratsPret->setInstrument(null);

    public function removeIntervention(Intervention $intervention): static
    {
        if ($this->intervention->removeElement($intervention)) {
            // set the owning side to null (unless already changed)
            if ($intervention->getInstrument() === $this) {
                $intervention->setInstrument(null);

            }
        }

        return $this;
    }
}
