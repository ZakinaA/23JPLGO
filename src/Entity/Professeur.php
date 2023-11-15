<?php

namespace App\Entity;

use App\Repository\ProfesseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfesseurRepository::class)]
class Professeur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column]
    private ?int $numRue = null;

    #[ORM\Column(length: 255)]
    private ?string $rue = null;

    #[ORM\Column]
    private ?int $copos = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ville = null;

    #[ORM\Column(nullable: true)]
    private ?int $tel = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mail = null;

    #[ORM\OneToMany(mappedBy: 'idProfesseur', targetEntity: Cours::class)]
    private Collection $cours;

    #[ORM\ManyToMany(targetEntity: TypeInstrument::class, inversedBy: 'professeurs')]
    private Collection $idTypeInstrument;

    public function __construct()
    {
        $this->cours = new ArrayCollection();
        $this->idTypeInstrument = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNumRue(): ?int
    {
        return $this->numRue;
    }

    public function setNumRue(int $numRue): static
    {
        $this->numRue = $numRue;

        return $this;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(string $rue): static
    {
        $this->rue = $rue;

        return $this;
    }

    public function getCopos(): ?int
    {
        return $this->copos;
    }

    public function setCopos(int $copos): static
    {
        $this->copos = $copos;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getTel(): ?int
    {
        return $this->tel;
    }

    public function setTel(?int $tel): static
    {
        $this->tel = $tel;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(?string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * @return Collection<int, Cours>
     */
    public function getCours(): Collection
    {
        return $this->cours;
    }

    public function addCour(Cours $cour): static
    {
        if (!$this->cours->contains($cour)) {
            $this->cours->add($cour);
            $cour->setIdProfesseur($this);
        }

        return $this;
    }

    public function removeCour(Cours $cour): static
    {
        if ($this->cours->removeElement($cour)) {
            // set the owning side to null (unless already changed)
            if ($cour->getIdProfesseur() === $this) {
                $cour->setIdProfesseur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TypeInstrument>
     */
    public function getIdTypeInstrument(): Collection
    {
        return $this->idTypeInstrument;
    }

    public function addIdTypeInstrument(TypeInstrument $idTypeInstrument): static
    {
        if (!$this->idTypeInstrument->contains($idTypeInstrument)) {
            $this->idTypeInstrument->add($idTypeInstrument);
        }

        return $this;
    }

    public function removeIdTypeInstrument(TypeInstrument $idTypeInstrument): static
    {
        $this->idTypeInstrument->removeElement($idTypeInstrument);

        return $this;
    }
}