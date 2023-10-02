<?php

namespace pizzashop\shop\domain\service;

use pizzashop\shop\Exception\ServiceCatalogueNotFoundException;
use pizzashop\shop\domain\entities\catalogue\Produit;
use pizzashop\shop\domain\dto\catalogue\ProduitDTO;

class CatalogueService implements iCatalogueService
{
    /**
     * @throws ServiceCatalogueNotFoundException
     */
    public function recupererProduit(int $id_produit): ProduitDTO
    {
        if (Produit::where('id', $id_produit)->exists()) {
            $produit = Produit::find($id_produit);
            return new ProduitDTO(
                $produit->id,
                $produit->numero,
                $produit->libelle,
                $produit->description,
                $produit->image);
        } else {
            throw new ServiceCatalogueNotFoundException("Produit not found", 404);
        }
    }

}

