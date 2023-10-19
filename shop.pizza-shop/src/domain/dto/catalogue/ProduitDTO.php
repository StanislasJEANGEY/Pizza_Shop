<?php

namespace pizzashop\shop\domain\dto\catalogue;


/**
 * @method getDescription()
 * @method getImage()
 */
class ProduitDTO{



    private int $numero_produit;
    private string $libelle_produit;
    private string $libelle_categorie;
    private string $libelle_taille;
    private float $tarif;

    public function __construct(int $numero_produit, string $libelle_produit, string $libelle_categorie, string $libelle_taille, float $tarif)
    {
        $this->numero_produit = $numero_produit;
        $this->libelle_produit = $libelle_produit;
        $this->libelle_categorie = $libelle_categorie;
        $this->libelle_taille = $libelle_taille;
        $this->tarif = $tarif;
    }

    public function getPrix(): float
    {
        return $this->tarif;
    }

    public function getLibelle(): string
    {
        return $this->libelle_produit;
    }

    public function getLibelleTaille(): string
    {
        return $this->libelle_taille;
    }

    public function getNumeroProduit(): int
    {
        return $this->numero_produit;
    }

    public function getLibelleCategorie(): string
    {
        return $this->libelle_categorie;
    }

}