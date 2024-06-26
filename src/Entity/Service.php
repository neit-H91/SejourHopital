<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\OneToMany(mappedBy: 'leService', targetEntity: Chambre::class)]
    private Collection $lesChambres;

    #[ORM\OneToMany(mappedBy: 'le_service', targetEntity: User::class)]
    private Collection $users;

    public function __construct()
    {
        $this->lesChambres = new ArrayCollection();
        $this->users = new ArrayCollection();
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
     * @return Collection<int, Chambre>
     */
    public function getLesChambres(): Collection
    {
        return $this->lesChambres;
    }

    public function addLesChambre(Chambre $lesChambre): static
    {
        if (!$this->lesChambres->contains($lesChambre)) {
            $this->lesChambres->add($lesChambre);
            $lesChambre->setLeService($this);
        }

        return $this;
    }

    public function removeLesChambre(Chambre $lesChambre): static
    {
        if ($this->lesChambres->removeElement($lesChambre)) {
            // set the owning side to null (unless already changed)
            if ($lesChambre->getLeService() === $this) {
                $lesChambre->setLeService(null);
            }
        }

        return $this;
    }

    public function __toString(){
        return $this->libelle;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setLeService($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getLeService() === $this) {
                $user->setLeService(null);
            }
        }

        return $this;
    }
}