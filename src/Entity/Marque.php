<?php

namespace App\Entity;

use App\Repository\MarqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MarqueRepository::class)]
class Marque
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'marque', targetEntity: Instrument::class)]
    private Collection $idInstrument;

    public function __construct()
    {
        $this->idInstrument = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Instrument>
     */
    public function getIdInstrument(): Collection
    {
        return $this->idInstrument;
    }

    public function addIdInstrument(Instrument $idInstrument): static
    {
        if (!$this->idInstrument->contains($idInstrument)) {
            $this->idInstrument->add($idInstrument);
            $idInstrument->setMarque($this);
        }

        return $this;
    }

    public function removeIdInstrument(Instrument $idInstrument): static
    {
        if ($this->idInstrument->removeElement($idInstrument)) {
            // set the owning side to null (unless already changed)
            if ($idInstrument->getMarque() === $this) {
                $idInstrument->setMarque(null);
            }
        }

        return $this;
    }
}
