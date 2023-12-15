<?php

namespace App\Entity;

use App\Repository\LitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LitRepository::class)]
class Lit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\OneToMany(mappedBy: 'leLit', targetEntity: Sejour::class)]
    private Collection $lesSejours;

    #[ORM\ManyToOne(inversedBy: 'lits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Chambre $laChambre = null;

    public function __construct()
    {
        $this->lesSejours = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, Sejour>
     */
    public function getLesSejours(): Collection
    {
        return $this->lesSejours;
    }

    public function addLesSejour(Sejour $lesSejour): static
    {
        if (!$this->lesSejours->contains($lesSejour)) {
            $this->lesSejours->add($lesSejour);
            $lesSejour->setLeLit($this);
        }

        return $this;
    }

    public function removeLesSejour(Sejour $lesSejour): static
    {
        if ($this->lesSejours->removeElement($lesSejour)) {
            // set the owning side to null (unless already changed)
            if ($lesSejour->getLeLit() === $this) {
                $lesSejour->setLeLit(null);
            }
        }

        return $this;
    }

    public function getLaChambre(): ?Chambre
    {
        return $this->laChambre;
    }

    public function setLaChambre(?Chambre $laChambre): static
    {
        $this->laChambre = $laChambre;

        return $this;
    }
    public function __toString(){
        return $this->libelle;
    }
}