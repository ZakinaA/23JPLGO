<?php

namespace App\Entity;

use App\Repository\InterPretRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InterPretRepository::class)]
class InterPret
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $quotite = null;

    #[ORM\ManyToOne(inversedBy: 'interPret')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Intervention $intervention = null;

    #[ORM\ManyToOne(inversedBy: 'contratPret')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ContratPret $contratPret = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuotite(): ?string
    {
        return $this->quotite;
    }

    public function setQuotite(string $quotite): static
    {
        $this->quotite = $quotite;

        return $this;
    }

    public function getIntervention(): ?Intervention
    {
        return $this->intervention;
    }

    public function setIntervention(?Intervention $intervention): static
    {
        $this->intervention = $intervention;

        return $this;
    }

    public function getContratPret(): ?ContratPret
    {
        return $this->contratPret;
    }

    public function setContratPret(?ContratPret $contratPret): static
    {
        $this->contratPret = $contratPret;

        return $this;
    }
}
