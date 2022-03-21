<?php

namespace App\Entity;

use App\Repository\FichesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FichesRepository::class)
 */
class Fiches
{
    const ETATVALIDE = true;

    const ETATNONVALIDE = false;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="fiches")
     * @ORM\JoinColumn(nullable=false)
     */
    private $users;

    /**
     * @ORM\Column(type="integer")
     */
    private $users_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $periode;

    /**
     * @ORM\Column(type="integer")
     */
    private $repas_midi;

    /**
     * @ORM\Column(type="integer")
     */
    private $nuits;

    /**
     * @ORM\Column(type="integer")
     */
    private $etape;

    /**
     * @ORM\Column(type="integer")
     */
    private $km;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateAdd;

    /**
     * @var boolean
     * @ORM\column(name="etat", type="boolean")
     */
    private $etat;

    public function __construct()
    {
        $this->dateAdd = new \DateTime();
        $this->etat = self::ETATNONVALIDE;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function getUsers_id(): ?int
    {
        return $this->users_id;
    }

    public function setUsers_id(int $users_id): self
    {
        $this->users = $users_id;

        return $this;
    }

    public function getPeriode(): ?string
    {
        return $this->periode;
    }

    public function setPeriode(string $periode): self
    {
        $this->periode = $periode;

        return $this;
    }

    public function getRepas_midi(): ?int
    {
        return $this->repas_midi;
    }

    public function setRepas_midi(int $repas_midi): self
    {
        $this->repas_midi = $repas_midi;

        return $this;
    }

    public function getRepasMidi(): ?int
    {
        return $this->repas_midi;
    }

    public function setRepasMidi(int $repas_midi): self
    {
        $this->repas_midi = $repas_midi;

        return $this;
    }

    public function getNuits(): ?int
    {
        return $this->nuits;
    }

    public function setNuits(int $nuits): self
    {
        $this->nuits = $nuits;

        return $this;
    }

    public function getEtape(): ?int
    {
        return $this->etape;
    }

    public function setEtape(int $etape): self
    {
        $this->etape = $etape;

        return $this;
    }

    public function getKm(): ?int
    {
        return $this->km;
    }

    public function setKm(int $km): self
    {
        $this->km = $km;

        return $this;
    }

    public function getDateAdd(): ?\DateTimeInterface
    {
        return $this->dateAdd;
    }

    public function setDateAdd(\DateTimeInterface $dateAdd): self
    {
        $this->dateAdd = $dateAdd;

        return $this;
    }

    public function getEtat()
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

}
