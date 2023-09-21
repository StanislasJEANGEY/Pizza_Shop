<?php

namespace pizzashop\shop\domain\service;

use pizzaShop\shop\domain\entities\commande\Commande;
use pizzashop\shop\shop\domain\dto\commande\CommandeDTO;

class CommandeService
{

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
}