<?php

namespace pizzashop\shop\domain\service;

use pizzashop\shop\domain\dto\catalogue\ProduitDTO;

interface iCatalogueService {
    public function recupererProduit(int $numero_produit, int $taille): ProduitDTO;

    public function listerProduits(): array;

    public function getProduitById(int $id): ProduitDTO;

    public function listerProduitsParCategorie(int $idCategorie): array;
}