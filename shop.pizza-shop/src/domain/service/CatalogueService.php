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
    public function recupererProduit(int $numero_produit, int $taille): ProduitDTO
    {
        if (Produit::where('numero', $numero_produit)->exists()) {
            $produit = Produit::where('numero', $numero_produit)
            ->with(['categorie', 'tarifs' => function ($query) use ($taille) {
                $query->where('taille_id', $taille);
            }])
            ->first();

            return new ProduitDTO(
                $produit->numero,
                $produit->libelle,
                $produit->description,
                $produit->image,
                $produit->categorie->libelle,
                $produit->tailles->map(function ($taille) {
                    return $taille->libelle;
                }),
                $produit->tarifs->first()->pivot->tarif);
        } else {
            throw new ServiceCatalogueNotFoundException("Produit not found", 404);
        }
    }

    /**
     * @throws ServiceCatalogueNotFoundException
     */
    public function getProduitById(int $id): ProduitDTO
    {
        $produit = Produit::where('numero', $id)
            ->first();

        if ($produit) {
            return new ProduitDTO(
                $produit->numero,
                $produit->libelle,
                $produit->description,
                $produit->image,
                $produit->categorie->libelle,
                $produit->tailles->map(function ($taille) {
                    return $taille->libelle;
                }),
                $produit->tarifs->first()->pivot->tarif);
        } else {
            throw new ServiceCatalogueNotFoundException("Produit not found", 404);
        }
    }

    public function listerProduits(): array
    {
        $produits = Produit::with(['categorie', 'tailles', 'tarifs'])->get();
        $produitsDTO = [];
        foreach ($produits as $produit) {
            $produitsDTO[] = new ProduitDTO(
                $produit->numero,
                $produit->libelle,
                $produit->description,
                $produit->image,
                $produit->categorie->libelle,
                $produit->tailles->map(function ($taille) {
                    return $taille->libelle;
                }),
                $produit->tarifs->first()->pivot->tarif);
        }
        return $produitsDTO;
    }

    public function listerProduitsParCategorie(int $id): array
    {
        $produits = Produit::where('categorie_id', $id)
            ->with(['categorie', 'tailles', 'tarifs'])
            ->get();

        $produitsDTO = [];
        foreach ($produits as $produit) {
            $produitsDTO[] = new ProduitDTO(
                $produit->numero,
                $produit->libelle,
                $produit->description,
                $produit->image,
                $produit->categorie->libelle,
                $produit->tailles->map(function ($taille) {
                    return $taille->libelle;
                }),
                $produit->tarifs->first()->pivot->tarif
            );
        }

        return $produitsDTO;
    }

}

