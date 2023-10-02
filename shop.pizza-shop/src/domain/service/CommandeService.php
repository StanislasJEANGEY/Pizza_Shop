<?php

namespace pizzashop\shop\domain\service;

use pizzashop\shop\domain\dto\commande\CommandeDTO;
use pizzaShop\shop\domain\entities\commande\Commande;
use pizzashop\shop\Exception\ServiceCommandeNotFoundException;

class CommandeService implements iCommandeService
{
    protected $catalogueService;

    /**
     * @throws ServiceCommandeNotFoundException
     */
    public function accederCommande(string $id_commade) : CommandeDTO
    {
        if ($commande = Commande::find($id_commade)) {
            return new CommandeDTO(
                $commande->id,
                $commande->date_commande,
                $commande->type_livraison,
                $commande->delai_commande,
                $commande->etat_commande,
                $commande->montant_commande,
                $commande->mail_client);
        } else {
            throw new ServiceCommandeNotFoundException("Commande not found", 404);
        }
    }

    /**
     * @throws ServiceCommandeNotFoundException
     */
    public function validerCommande(string $id_commande) : CommandeDTO
    {
        if ($commande = Commande::find($id_commande)) {
            $commande->etat_commande = Commande::ETAT_VALIDE;
            $commande->save();
            return new CommandeDTO(
                $commande->id,
                $commande->date_commande,
                $commande->type_livraison,
                $commande->delai_commande,
                $commande->etat_commande,
                $commande->montant_commande,
                $commande->mail_client);
        } else {
            throw new ServiceCommandeNotFoundException("Commande not found", 404);
        }
    }

    public function creerCommande(CommandeDTO $commandeDTO) : CommandeDTO
    {
        $identifiantCommande = uniqid();
        $dateCommande = date("Y-m-d H:i:s");
        $etatCommande = Commande::ETAT_CREE;
        $itemsCommandes = $commandeDTO->getItems();
        $montantCommande = 0;
        foreach ($itemsCommandes as $item) {
            $produit = $this->catalogueService->recupererProduit($item->getNumero());
            $sousTotal = $produit->getPrix() * $item->getQuantite();
            $montantCommande += $sousTotal;
        }
        return new CommandeDTO(
            $identifiantCommande,
            $dateCommande,
            $commandeDTO->getTypeLivraison(),
            $commandeDTO->getDelai(),
            $etatCommande,
            $montantCommande,
            $commandeDTO->getMailClient(),
            $itemsCommandes);
    }
}

