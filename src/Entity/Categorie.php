<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
class Categorie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Products::class, mappedBy="categorie")
     */
    private $product;

    public function __toString()
    {
        return $this->getName();
    }

    public function __construct()
    {
        $this->product = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Products[]
     */
    public function getProduct(): Collection
    {
        return $this->product;
    }

    public function addProduct(Products $product): self
    {
        if (!$this->product->contains($product)) {
            $this->product[] = $product;
            $product->setCategorie($this);
        }

        return $this;
    }

    public function removeProduct(Products $product): self
    {
        if ($this->product->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getCategorie() === $this) {
                $product->setCategorie(null);
            }
        }

        return $this;
    }
}
