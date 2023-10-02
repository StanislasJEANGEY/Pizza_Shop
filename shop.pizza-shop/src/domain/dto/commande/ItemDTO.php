<?php

namespace pizzashop\shop\domain\dto\commande;

use pizzashop\shop\domain\dto\DTO;

class ItemDTO extends DTO{

    public int $id_items;
    public int $id_commande;
    public int $numero_produit;
    public int $quantite_items;
    public float $tarif_items;
    public string $libelle_items;
    public string $libelle_taille;
    public int $taille_items;

    public function __construct(int $id_items, int $id_commande, int $numero_produit, int $quantite_items, float $tarif_items, string $libelle_items, string $libelle_taille, int $taille_items)
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

}