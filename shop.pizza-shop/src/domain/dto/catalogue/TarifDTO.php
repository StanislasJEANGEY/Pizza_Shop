<?php

namespace pizzashop\shop\domain\dto\catalogue;

class TarifDTO
{
    public int $produit_id;
    public int $taille_id;
    public float $tarif;

    /**
     * @param int $produit_id
     * @param int $taille_id
     * @param float $tarif
     */
    public function __construct(mixed $produit_id, mixed $taille_id, mixed $tarif)
    {
        $this->produit_id = $produit_id;
        $this->taille_id = $taille_id;
        $this->tarif = $tarif;
    }
}