<?php

namespace pizzashop\shop\domain\dto\catalogue;

use pizzashop\shop\domain\dto\DTO;

class ProduitDTO extends DTO
{

    public int $numero_produit;
    public string $libelle_produit;
    public string $libelle_categorie;
    public string $libelle_taille;
    public string $tarif;

    public function __construct(int $numero_produit, string $libelle_produit, string $libelle_categorie, string $libelle_taille, $tarif)
    {
        $this->numero_produit = $numero_produit;
        $this->libelle_produit = $libelle_produit;
        $this->libelle_categorie = $libelle_categorie;
        $this->libelle_taille = $libelle_taille;
        $this->tarif = $tarif;
    }

    public function getPrix(): string
    {
        return $this->tarif;
    }

    public function getLibelle(): string
    {
        return $this->libelle_produit;
    }

    public function getLibelleTaille($taille): string
    {
        return $this->libelle_taille;
    }


}