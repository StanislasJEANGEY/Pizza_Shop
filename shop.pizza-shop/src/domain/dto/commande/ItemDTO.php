<?php

namespace pizzashop\shop\domain\dto\commande;


class ItemDTO{

    private string $id_commande;
    private int $numero_produit;
    private int $quantite_items;
    private float $tarif_items;
    private string $libelle_items;
    private string $libelle_taille;
    private int $taille_items;

    public function __construct(string $id_commande, int $numero_produit, int $quantite_items, float $tarif_items, string $libelle_items, string $libelle_taille, int $taille_items)
    {
        $this->id_commande = $id_commande;
        $this->numero_produit = $numero_produit;
        $this->quantite_items = $quantite_items;
        $this->tarif_items = $tarif_items;
        $this->libelle_items = $libelle_items;
        $this->libelle_taille = $libelle_taille;
        $this->taille_items = $taille_items;
    }

    public function getIdCommande(): string
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

    public function __toString(): string
    {
        return "ItemDTO{" .
            "id_commande='" . $this->id_commande . '\'' .
            ", numero_produit=" . $this->numero_produit .
            ", quantite_items=" . $this->quantite_items .
            ", tarif_items=" . $this->tarif_items .
            ", libelle_items='" . $this->libelle_items . '\'' .
            ", libelle_taille='" . $this->libelle_taille . '\'' .
            ", taille_items=" . $this->taille_items .
            '}';
    }

}