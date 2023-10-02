<?php

namespace pizzashop\shop\domain\service;

use pizzashop\shop\domain\dto\catalogue\ProduitDTO;

interface iCatalogueService {
    public function recupererProduit(int $id_produit): ProduitDTO;
}