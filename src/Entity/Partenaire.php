<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PartenaireRepository")
 * @UniqueEntity(fields={"ninea"},message="Cet utilisateur existe déjà")
 */
class Partenaire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="ninea",type="string", length=255, unique=true)
     * @Assert\Regex(
     *     pattern="/^(\+[1-9][0-9]*(\([0-9]*\)|-[0-9]*-))?[0]?[1-9][0-9\-]*$/",
     *     match=true,
     *     message="Entrez un ninea valide"
     * )
     */
    private $ninea;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $siege;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $raisonSociale;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank(message="Vous devez saisir un email")
     * @Assert\Email(
     *     message = " '{{ value }}' Cet email n'est pas valide.",
     *     checkMX = true
     * )
     */
    private $emailP;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex(
     *     pattern="/^(\+[1-9][0-9]*(\([0-9]*\)|-[0-9]*-))?[0]?[1-9][0-9\-]*$/",
     *     match=true,
     *     message="Votre numero ne doit pas contenir de lettre"
     * )
     */
    private $telephoneP;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Compte", mappedBy="partenaire")
     */
    private $comptes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Utilisateur", mappedBy="partenaire")
     */
    private $utilisateurs;

    public function __construct()
    {
        $this->comptes = new ArrayCollection();
        $this->utilisateurs = new ArrayCollection();
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNinea(): ?string
    {
        return $this->ninea;
    }

    public function setNinea(string $ninea): self
    {
        $this->ninea = $ninea;

        return $this;
    }

    public function getSiege(): ?string
    {
        return $this->siege;
    }

    public function setSiege(string $siege): self
    {
        $this->siege = $siege;

        return $this;
    }

    public function getRaisonSociale(): ?string
    {
        return $this->raisonSociale;
    }

    public function setRaisonSociale(string $raisonSociale): self
    {
        $this->raisonSociale = $raisonSociale;

        return $this;
    }

    public function getEmailP(): ?string
    {
        return $this->emailP;
    }

    public function setEmailP(string $emailP): self
    {
        $this->emailP = $emailP;

        return $this;
    }

    public function getTelephoneP(): ?string
    {
        return $this->telephoneP;
    }

    public function setTelephoneP(string $telephoneP): self
    {
        $this->telephoneP = $telephoneP;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt = new \DateTime('now');
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|Compte[]
     */
    public function getComptes(): Collection
    {
        return $this->comptes;
    }

    public function addCompte(Compte $compte): self
    {
        if (!$this->comptes->contains($compte)) {
            $this->comptes[] = $compte;
            $compte->setPartenaire($this);
        }

        return $this;
    }

    public function removeCompte(Compte $compte): self
    {
        if ($this->comptes->contains($compte)) {
            $this->comptes->removeElement($compte);
            // set the owning side to null (unless already changed)
            if ($compte->getPartenaire() === $this) {
                $compte->setPartenaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Utilisateur[]
     */
    public function getUtilisateurs(): Collection
    {
        return $this->utilisateurs;
    }

    public function addUtilisateur(Utilisateur $utilisateur): self
    {
        if (!$this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs[] = $utilisateur;
            $utilisateur->setPartenaire($this);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): self
    {
        if ($this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs->removeElement($utilisateur);
            // set the owning side to null (unless already changed)
            if ($utilisateur->getPartenaire() === $this) {
                $utilisateur->setPartenaire(null);
            }
        }

        return $this;
    }
}
