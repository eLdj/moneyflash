<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

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
     * @Groups({"envoie", "show"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"envoie", "show"})
     */
    private $codeGenere;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"envoie", "show"})
     */
    private $montantTransfert;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"envoie", "show"})
     */
    private $fraisTransaction;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"envoie", "show"})
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
     * @Groups({"envoie", "show"})
     */
    private $commissionEnvoie;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @Groups({"envoie", "show"})
     */
    private $statut;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateRetrait;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="transactions")
     */
    private $compteEnv;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="transactions")
     */
    private $compteRet;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups({"envoie", "show"})
     */
    private $nomCompletE;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"envoie", "show"})
     */
    private $telE;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"envoie", "show"})
     */
    private $adresseE;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"envoie", "show"})
     */
    private $cinE;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"envoie", "show"})
     */
    private $nomCompletB;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"envoie", "show"})
     */
    private $telB;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"envoie", "show"})
     */
    private $adresseB;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cinB;

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

    public function getNomCompletE(): ?string
    {
        return $this->nomCompletE;
    }

    public function setNomCompletE(string $nomCompletE): self
    {
        $this->nomCompletE = $nomCompletE;

        return $this;
    }

    public function getTelE(): ?string
    {
        return $this->telE;
    }

    public function setTelE(string $telE): self
    {
        $this->telE = $telE;

        return $this;
    }

    public function getAdresseE(): ?string
    {
        return $this->adresseE;
    }

    public function setAdresseE(?string $adresseE): self
    {
        $this->adresseE = $adresseE;

        return $this;
    }

    public function getCinE(): ?string
    {
        return $this->cinE;
    }

    public function setCinE(string $cinE): self
    {
        $this->cinE = $cinE;

        return $this;
    }

    public function getNomCompletB(): ?string
    {
        return $this->nomCompletB;
    }

    public function setNomCompletB(string $nomCompletB): self
    {
        $this->nomCompletB = $nomCompletB;

        return $this;
    }

    public function getTelB(): ?string
    {
        return $this->telB;
    }

    public function setTelB(string $telB): self
    {
        $this->telB = $telB;

        return $this;
    }

    public function getAdresseB(): ?string
    {
        return $this->adresseB;
    }

    public function setAdresseB(?string $adresseB): self
    {
        $this->adresseB = $adresseB;

        return $this;
    }

    public function getCinB(): ?string
    {
        return $this->cinB;
    }

    public function setCinB(string $cinB): self
    {
        $this->cinB = $cinB;

        return $this;
    }

}
