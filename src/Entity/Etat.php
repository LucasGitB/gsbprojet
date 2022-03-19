<?php

namespace App\Entity;

use App\Repository\EtatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EtatRepository::class)
 */
class Etat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Fiches::class, mappedBy="etat")
     */
    private $etat;

    /**
     * @ORM\OneToMany(targetEntity=FicheHorsForfait::class, mappedBy="etat")
     */
    private $ficheHorsForfaits;

    public function __construct()
    {
        $this->etat = new ArrayCollection();
        $this->ficheHorsForfaits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection|Fiches[]
     */
    public function getEtat(): Collection
    {
        return $this->etat;
    }

    public function addEtat(Fiches $etat): self
    {
        if (!$this->etat->contains($etat)) {
            $this->etat[] = $etat;
            $etat->setEtat($this);
        }

        return $this;
    }

    public function removeEtat(Fiches $etat): self
    {
        if ($this->etat->removeElement($etat)) {
            // set the owning side to null (unless already changed)
            if ($etat->getEtat() === $this) {
                $etat->setEtat(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|FicheHorsForfait[]
     */
    public function getFicheHorsForfaits(): Collection
    {
        return $this->ficheHorsForfaits;
    }

    public function addFicheHorsForfait(FicheHorsForfait $ficheHorsForfait): self
    {
        if (!$this->ficheHorsForfaits->contains($ficheHorsForfait)) {
            $this->ficheHorsForfaits[] = $ficheHorsForfait;
            $ficheHorsForfait->setEtat($this);
        }

        return $this;
    }

    public function removeFicheHorsForfait(FicheHorsForfait $ficheHorsForfait): self
    {
        if ($this->ficheHorsForfaits->removeElement($ficheHorsForfait)) {
            // set the owning side to null (unless already changed)
            if ($ficheHorsForfait->getEtat() === $this) {
                $ficheHorsForfait->setEtat(null);
            }
        }

        return $this;
    }
}
