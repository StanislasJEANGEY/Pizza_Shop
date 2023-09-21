<?php

namespace pizzashop\shop\shop\domain\entities\catalogue;

interface iCatalogueService {
    public function recupererProduit(int $id_produit): ProduitDTO;
}