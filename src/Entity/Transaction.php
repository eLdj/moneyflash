<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TransactionRepository")
 */
class Transaction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codeGenere;

    /**
     * @ORM\Column(type="integer")
     */
    private $montantTransfert;

    /**
     * @ORM\Column(type="integer")
     */
    private $fraisTransaction;

    /**
     * @ORM\Column(type="integer")
     */
    private $totalEnvoi;

    /**
     * @ORM\Column(type="integer")
     */
    private $commissionEtat;

    /**
     * @ORM\Column(type="integer")
     */
    private $commissionSysteme;

    /**
     * @ORM\Column(type="integer")
     */
    private $commissionRetrait;

    /**
     * @ORM\Column(type="integer")
     */
    private $commissionEnvoie;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $statut;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateRetrait;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Expediteur", inversedBy="transactions")
     */
    private $expediteur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Beneficiaire", inversedBy="transactions")
     */
    private $beneficiaire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="transactions")
     */
    private $compteEnv;

     /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="transactions")
     */
    private $compteRet;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCodeGenere(): ?string
    {
        return $this->codeGenere;
    }

    public function setCodeGenere(string $codeGenere): self
    {
        $this->codeGenere = $codeGenere;

        return $this;
    }

    public function getMontantTransfert(): ?int
    {
        return $this->montantTransfert;
    }

    public function setMontantTransfert(int $montantTransfert): self
    {
        $this->montantTransfert = $montantTransfert;

        return $this;
    }

    public function getFraisTransaction(): ?int
    {
        return $this->fraisTransaction;
    }

    public function setFraisTransaction(int $fraisTransaction): self
    {
        $this->fraisTransaction = $fraisTransaction;

        return $this;
    }

    public function getTotalEnvoi(): ?int
    {
        return $this->totalEnvoi;
    }

    public function setTotalEnvoi(int $totalEnvoi): self
    {
        $this->totalEnvoi = $totalEnvoi;

        return $this;
    }

    public function getCommissionEtat(): ?int
    {
        return $this->commissionEtat;
    }

    public function setCommissionEtat(int $commissionEtat): self
    {
        $this->commissionEtat = $commissionEtat;

        return $this;
    }

    public function getCommissionSysteme(): ?int
    {
        return $this->commissionSysteme;
    }

    public function setCommissionSysteme(int $commissionSysteme): self
    {
        $this->commissionSysteme = $commissionSysteme;

        return $this;
    }

    public function getCommissionRetrait(): ?int
    {
        return $this->commissionRetrait;
    }

    public function setCommissionRetrait(int $commissionRetrait): self
    {
        $this->commissionRetrait = $commissionRetrait;

        return $this;
    }

    public function getCommissionEnvoie(): ?int
    {
        return $this->commissionEnvoie;
    }

    public function setCommissionEnvoie(int $commissionEnvoie): self
    {
        $this->commissionEnvoie = $commissionEnvoie;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getDateRetrait(): ?\DateTimeInterface
    {
        return $this->dateRetrait;
    }

    public function setDateRetrait(\DateTimeInterface $dateRetrait): self
    {
        $this->dateRetrait = $dateRetrait;

        return $this;
    }

    public function getExpediteur(): ?Expediteur
    {
        return $this->expediteur;
    }

    public function setExpediteur(?Expediteur $expediteur): self
    {
        $this->expediteur = $expediteur;

        return $this;
    }

    public function getBeneficiaire(): ?Beneficiaire
    {
        return $this->beneficiaire;
    }

    public function setBeneficiaire(?Beneficiaire $beneficiaire): self
    {
        $this->beneficiaire = $beneficiaire;

        return $this;
    }

    public function getCompteEnv(): ?Compte
    {
        return $this->compteEnv;
    }

    public function setCompteEnv(?Compte $compteEnv): self
    {
        $this->compteEnv = $compteEnv;

        return $this;
    }

    public function getCompteRet(): ?Compte
    {
        return $this->compteRet;
    }

    public function setCompteRet(?Compte $compteRet): self
    {
        $this->compteRet = $compteRet;

        return $this;
    }
}
