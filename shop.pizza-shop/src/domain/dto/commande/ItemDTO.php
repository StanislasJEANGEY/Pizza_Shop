<?php

namespace pizzashop\shop\domain\dto\commande;

use pizzashop\shop\domain\dto\DTO;

class ItemDTO extends DTO{

    public int $id_items;
    public string $id_commande;
    public int $numero_produit;
    public int $quantite_items;
    public float $tarif_items;
    public string $libelle_items;
    public string $libelle_taille;
    public int $taille_items;

    public function __construct(int $id_items, string $id_commande, int $numero_produit, int $quantite_items, float $tarif_items, string $libelle_items, string $libelle_taille, int $taille_items)
    {
        $this->id_items = $id_items;
        $this->id_commande = $id_commande;
        $this->numero_produit = $numero_produit;
        $this->quantite_items = $quantite_items;
        $this->tarif_items = $tarif_items;
        $this->libelle_items = $libelle_items;
        $this->libelle_taille = $libelle_taille;
        $this->taille_items = $taille_items;
    }

    public function getIdItems(): int
    {
        return $this->id_items;
    }

    public function getIdCommande(): int
    {
        return $this->id_commande;
    }

    public function getNumeroProduit(): int
    {
        return $this->numero_produit;
    }

    public function getQuantiteItems(): int
    {
        return $this->quantite_items;
    }

    public function getTarifItems(): float
    {
        return $this->tarif_items;
    }

    public function getLibelleItems(): string
    {
        return $this->libelle_items;
    }

    public function getLibelleTaille(): string
    {
        return $this->libelle_taille;
    }

    public function getTailleItems(): int
    {
        return $this->taille_items;
    }



}