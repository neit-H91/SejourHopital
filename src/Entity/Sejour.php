<?php

namespace App\Entity;

use App\Repository\SejourRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\ArgumentResolver\EntityValueResolver;

#[ORM\Entity(repositoryClass: SejourRepository::class)]
class Sejour
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $commentaire = null;

    #[ORM\Column]
    private ?bool $estArrive = null;

    #[ORM\Column]
    private ?bool $estParti = null;

    #[ORM\ManyToOne(inversedBy: 'lesSejours')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Lit $leLit = null;

    #[ORM\ManyToOne(inversedBy: 'lesSejours')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $lePatient = null;

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

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): static
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function isEstArrive(): ?bool
    {
        return $this->estArrive;
    }

    public function setEstArrive(bool $estArrive): static
    {
        $this->estArrive = $estArrive;

        return $this;
    }

    public function isEstParti(): ?bool
    {
        return $this->estParti;
    }

    public function setEstParti(bool $estParti): static
    {
        $this->estParti = $estParti;

        return $this;
    }

    public function getLeLit(): ?Lit
    {
        return $this->leLit;
    }

    public function setLeLit(?Lit $leLit): static
    {
        $this->leLit = $leLit;

        return $this;
    }

    public function getLePatient(): ?User
    {
        return $this->lePatient;
    }

    public function setLePatient(?User $lePatient): static
    {
        $this->lePatient = $lePatient;

        return $this;
    }
}