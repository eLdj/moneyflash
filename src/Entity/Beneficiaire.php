<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BeneficiaireRepository")
 */
class Beneficiaire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomCompletB;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresseB;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telB;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $cinB;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="beneficiaire")
     */
    private $transactions;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAdresseB(): ?string
    {
        return $this->adresseB;
    }

    public function setAdresseB(?string $adresseB): self
    {
        $this->adresseB = $adresseB;

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

    public function getCinB(): ?string
    {
        return $this->cinB;
    }

    public function setCinB(string $cinB): self
    {
        $this->cinB = $cinB;

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setBeneficiaire($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->contains($transaction)) {
            $this->transactions->removeElement($transaction);
            // set the owning side to null (unless already changed)
            if ($transaction->getBeneficiaire() === $this) {
                $transaction->setBeneficiaire(null);
            }
        }

        return $this;
    }
}
