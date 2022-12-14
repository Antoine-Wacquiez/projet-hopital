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

    #[ORM\OneToMany(mappedBy: 'service', targetEntity: Sejour::class)]
    private Collection $sejour;

    public function __construct()
    {
        $this->sejour = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, Sejour>
     */
    public function getSejour(): Collection
    {
        return $this->sejour;
    }

    public function addSejour(Sejour $sejour): self
    {
        if (!$this->sejour->contains($sejour)) {
            $this->sejour->add($sejour);
            $sejour->setService($this);
        }

        return $this;
    }

    public function removeSejour(Sejour $sejour): self
    {
        if ($this->sejour->removeElement($sejour)) {
            // set the owning side to null (unless already changed)
            if ($sejour->getService() === $this) {
                $sejour->setService(null);
            }
        }

        return $this;
    }
}
