<?php

namespace App\Entity;

use App\Repository\ProduitsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitsRepository::class)]
class Produits
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: CategorieProduits::class, inversedBy: 'produits')]
    private Collection $categories_produits;

    #[ORM\ManyToMany(targetEntity: MotsCles::class, inversedBy: 'produits')]
    private Collection $motsCles;

    #[ORM\Column(length: 255)]
    private ?string $photo = null;

    #[ORM\OneToMany(targetEntity: Panier::class, mappedBy: 'produit')]
    private Collection $paniers;

    

    public function __construct()
    {
        $this->categories_produits = new ArrayCollection();
        $this->motsClés = new ArrayCollection();
        $this->motsCles = new ArrayCollection();
        $this->paniers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, CategorieProduits>
     */
    public function getCategoriesProduits(): Collection
    {
        return $this->categories_produits;
    }

    public function addCategoriesProduit(CategorieProduits $categoriesProduit): static
    {
        if (!$this->categories_produits->contains($categoriesProduit)) {
            $this->categories_produits->add($categoriesProduit);
        }

        return $this;
    }

    public function removeCategoriesProduit(CategorieProduits $categoriesProduit): static
    {
        $this->categories_produits->removeElement($categoriesProduit);

        return $this;
    }

    /**
     * @return Collection<int, MotsCles>
     */
    public function getMotsCles(): Collection
    {
        return $this->motsCles;
    }

    public function addMotsCle(MotsCles $motsCle): static
    {
        if (!$this->motsCles->contains($motsCle)) {
            $this->motsCles->add($motsCle);
        }

        return $this;
    }

    public function removeMotsCle(MotsCles $motsCle): static
    {
        $this->motsCles->removeElement($motsCle);

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * @return Collection<int, Panier>
     */
    public function getPaniers(): Collection
    {
        return $this->paniers;
    }

    public function addPanier(Panier $panier): static
    {
        if (!$this->paniers->contains($panier)) {
            $this->paniers->add($panier);
            $panier->setProduit($this);
        }

        return $this;
    }

    public function removePanier(Panier $panier): static
    {
        if ($this->paniers->removeElement($panier)) {
            // set the owning side to null (unless already changed)
            if ($panier->getProduit() === $this) {
                $panier->setProduit(null);
            }
        }

        return $this;
    }


    
}
