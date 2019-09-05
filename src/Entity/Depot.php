<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DepotRepository")
 */
class Depot
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="bigint")
     *  /**
     * @Assert\GreaterThanOrEqual(75000,message="votre dépôt doit être suppérieru à 75000")
     * @Groups({"find"})
     * 
     */
    private $montantDepot;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"find"})
     */
    private $dateDepot;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", inversedBy="depots")
     * @Groups({"find"})
     * 
     */
    private $caissier;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="depots")
     */
    private $compte;
    
    public function __construct()
    {
        $this->dateDepot;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantDepot(): ?int
    {
        return $this->montantDepot;
    }

    public function setMontantDepot(int $montantDepot): self
    {
        $this->montantDepot = $montantDepot;

        return $this;
    }

    public function getDateDepot(): ?\DateTimeInterface
    {
        return $this->dateDepot;
    }

    public function setDateDepot(\DateTimeInterface $dateDepot): self
    {
        $this->dateDepot = $dateDepot;

        return $this;
    }

    public function getCaissier(): ?Utilisateur
    {
        return $this->caissier;
    }

    public function setCaissier(?Utilisateur $caissier): self
    {
        $this->caissier = $caissier;

        return $this;
    }

    public function getCompte(): ?Compte
    {
        return $this->compte;
    }

    public function setCompte(?Compte $compte): self
    {
        $this->compte = $compte;

        return $this;
    }
}
