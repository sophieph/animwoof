<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PanierRepository::class)
 */
class Panier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombreDeProduits;

    /**
     * @ORM\Column(type="float")
     */
    private $totalPrice;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="panier", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=Products::class, inversedBy="paniers")
     */
    private $produits;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreDeProduits(): ?int
    {
        return $this->nombreDeProduits;
    }

    public function setNombreDeProduits(int $nombreDeProduits): self
    {
        $this->nombreDeProduits = $nombreDeProduits;

        return $this;
    }

    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(float $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Products[]
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Products $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
        }

        return $this;
    }

    public function removeProduit(Products $produit): self
    {
        $this->produits->removeElement($produit);

        return $this;
    }
}
