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
    public function recupererProduit(int $numero_produit): ProduitDTO
    {
        if (Produit::where('numero', $numero_produit)->exists()) {
            $produit = Produit::where('numero', $numero_produit)
            ->with(['categorie', 'tarifs' => function ($query) {
                $query->where('taille_id', 1);
            }])
            ->first();


            return new ProduitDTO(
                $produit->numero,
                $produit->libelle,
                $produit->categorie->libelle,
                $produit->tailles->map(function ($taille) {
                    return $taille->libelle;
                }),
                0);
        } else {
            throw new ServiceCatalogueNotFoundException("Produit not found", 404);
        }
    }

}

