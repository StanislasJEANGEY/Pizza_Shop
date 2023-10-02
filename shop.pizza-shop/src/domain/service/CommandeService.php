<?php

namespace pizzashop\shop\domain\service;

use pizzashop\shop\domain\dto\commande\CommandeDTO;
use pizzaShop\shop\domain\entities\commande\Commande;
use pizzashop\shop\Exception\ServiceCommandeNotFoundException;

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

    public function creerCommande(CommandeDTO $commandeDTO) : CommandeDTO
    {
        $commande = new Commande();
        $commande->mail_client = $commandeDTO->mail_client;
        $commande->type_livraison = $commandeDTO->type_livraison;
        $commande->delai_commande = $commandeDTO->delai_commande;
        $commande->etat_commande = Commande::ETAT_CREE;
        $commande->date_commande = date("Y-m-d H:i:s");
        $commande->montant_commande = 0;
        $commande->save();
        $commandeDTO->numero_commande = $commande->id;
        $commandeDTO->date_commande = $commande->date_commande;
        $commandeDTO->etat_commande = $commande->etat_commande;
        $commandeDTO->montant_commande = $commande->montant_commande;
        return $commandeDTO;
    }
}

