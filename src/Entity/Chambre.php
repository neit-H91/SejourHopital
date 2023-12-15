<?php

namespace App\Entity;

use App\Repository\ChambreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChambreRepository::class)]
class Chambre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\OneToMany(mappedBy: 'laChambre', targetEntity: Lit::class)]
    private Collection $lits;

    #[ORM\ManyToOne(inversedBy: 'lesChambres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Service $leService = null;

    public function __construct()
    {
        $this->lits = new ArrayCollection();
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
     * @return Collection<int, Lit>
     */
    public function getLits(): Collection
    {
        return $this->lits;
    }

    public function addLit(Lit $lit): static
    {
        if (!$this->lits->contains($lit)) {
            $this->lits->add($lit);
            $lit->setLaChambre($this);
        }

        return $this;
    }

    public function removeLit(Lit $lit): static
    {
        if ($this->lits->removeElement($lit)) {
            // set the owning side to null (unless already changed)
            if ($lit->getLaChambre() === $this) {
                $lit->setLaChambre(null);
            }
        }

        return $this;
    }

    public function getLeService(): ?Service
    {
        return $this->leService;
    }

    public function setLeService(?Service $leService): static
    {
        $this->leService = $leService;

        return $this;
    }

    public function __toString(){
        return $this->libelle;
    }
}