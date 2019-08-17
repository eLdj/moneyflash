<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ExpediteurRepository")
 */
class Expediteur
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
    private $nomCompletE;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telE;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresseE;

    /**
     * @ORM\Column(type="string")
     */
    private $cinE;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="expediteur")
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
        $this->tel = $telE;

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
            $transaction->setExpediteur($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->contains($transaction)) {
            $this->transactions->removeElement($transaction);
            // set the owning side to null (unless already changed)
            if ($transaction->getExpediteur() === $this) {
                $transaction->setExpediteur(null);
            }
        }

        return $this;
    }
}
