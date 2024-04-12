<?php

namespace App\Entity;

use App\Repository\CategorieProduitsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieProduitsRepository::class)]
class CategorieProduits
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $typeDeProduit = null;

    #[ORM\Column(length: 255)]
    private ?string $Utilisation = null;

    #[ORM\Column(length: 255)]
    private ?string $nomProduit = null;

    #[ORM\ManyToMany(targetEntity: Produits::class, mappedBy: 'categories_produits')]
    private Collection $produits;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeDeProduit(): ?string
    {
        return $this->typeDeProduit;
    }

    public function setTypeDeProduit(string $typeDeProduit): static
    {
        $this->typeDeProduit = $typeDeProduit;

        return $this;
    }

    public function getUtilisation(): ?string
    {
        return $this->Utilisation;
    }

    public function setUtilisation(string $Utilisation): static
    {
        $this->Utilisation = $Utilisation;

        return $this;
    }

    public function getNomProduit(): ?string
    {
        return $this->nomProduit;
    }

    public function setNomProduit(string $nomProduit): static
    {
        $this->nomProduit = $nomProduit;

        return $this;
    }

    /**
     * @return Collection<int, Produits>
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produits $produit): static
    {
        if (!$this->produits->contains($produit)) {
            $this->produits->add($produit);
            $produit->addCategoriesProduit($this);
        }

        return $this;
    }

    public function removeProduit(Produits $produit): static
    {
        if ($this->produits->removeElement($produit)) {
            $produit->removeCategoriesProduit($this);
        }

        return $this;
    }
}
