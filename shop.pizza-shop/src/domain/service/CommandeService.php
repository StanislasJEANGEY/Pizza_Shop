<?php

namespace pizzashop\shop\domain\service;

use pizzaShop\shop\domain\entities\commande\Commande;
use pizzashop\shop\Exception\ServiceCommandeNotFoundException;
use pizzashop\shop\shop\domain\dto\commande\CommandeDTO;

class CommandeService implements iCommandeService
{

    /**
     * @throws ServiceCommandeNotFoundException
     */
    public function accederCommande(int $id_commande): CommandeDTO
    {
        if (Commande::where('id', $id_commande)->exists()) {
            $commande = Commande::find($id_commande);
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
    public function validerCommande(array $commande): CommandeDTO
    {
        if (isset($commande['mail_client']) && isset($commande['type_livraison']) && isset($commande['delai_commande']) && isset($commande['montant_commande'])) {
            $commande = new Commande();
            $commande->mail_client = $commande['mail_client'];
            $commande->type_livraison = $commande['type_livraison'];
            $commande->delai_commande = $commande['delai_commande'];
            $commande->montant_commande = $commande['montant_commande'];
            $commande->save();
            return $commande;
        } else {
            throw new ServiceCommandeNotFoundException("Commande not valid", 400);
        }
    }
}

