<?php

namespace App\Entity;

use App\Repository\EleveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EleveRepository::class)]
class Eleve
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $nom = null;

    #[ORM\Column(length: 20)]
    private ?string $prenom = null;

    #[ORM\Column(nullable: true)]
    private ?int $numRue = null;

    #[ORM\Column(length: 60, nullable: true)]
    private ?string $rue = null;

    #[ORM\Column]
    private ?int $copos = null;

    #[ORM\Column(length: 20)]
    private ?string $ville = null;

    #[ORM\Column(length: 16, nullable: true)]
    private ?string $tel = null;

    #[ORM\Column(length: 50)]
    private ?string $mail = null;

    #[ORM\OneToMany(mappedBy: 'eleve', targetEntity: ContratPret::class, orphanRemoval: true)]
    private Collection $contratsPret;

    #[ORM\ManyToMany(targetEntity: Responsable::class, inversedBy: 'eleve')]
    private Collection $responsables;

    public function __construct()
    {
        $this->contratsPret = new ArrayCollection();
        $this->responsables = new ArrayCollection();
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

    public function setNumRue(?int $numRue): static
    {
        $this->numRue = $numRue;

        return $this;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(?string $rue): static
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

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(?string $tel): static
    {
        $this->tel = $tel;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * @return Collection<int, ContratPret>
     */
    public function getContratsPret(): Collection
    {
        return $this->contratsPret;
    }

    public function addContratsPrT(ContratPret $contratsPrT): static
    {
        if (!$this->contratsPret->contains($contratsPrT)) {
            $this->contratsPret->add($contratsPrT);
            $contratsPrT->setEleve($this);
        }

        return $this;
    }

    public function removeContratsPrT(ContratPret $contratsPrT): static
    {
        if ($this->contratsPret->removeElement($contratsPrT)) {
            // set the owning side to null (unless already changed)
            if ($contratsPrT->getEleve() === $this) {
                $contratsPrT->setEleve(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Responsable>
     */
    public function getResponsables(): Collection
    {
        return $this->responsables;
    }

    public function addResponsable(Responsable $responsable): static
    {
        if (!$this->responsables->contains($responsable)) {
            $this->responsables->add($responsable);
        }

        return $this;
    }

    public function removeResponsable(Responsable $responsable): static
    {
        $this->responsables->removeElement($responsable);

        return $this;
    }
}
