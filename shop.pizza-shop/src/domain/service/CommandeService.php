<?php

namespace pizzashop\shop\domain\service;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use pizzashop\shop\domain\dto\commande\CommandeDTO;
use pizzashop\shop\domain\dto\commande\ItemDTO;
use pizzashop\shop\domain\entities\catalogue\Taille;
use pizzashop\shop\domain\entities\commande\Commande;
use pizzashop\shop\domain\entities\commande\Item;
use pizzashop\shop\Exception\ServiceCommandeNotFoundException;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validator as v;

class CommandeService implements iCommandeService
{

    /**
     * @throws ServiceCommandeNotFoundException
     */
    public function accederCommande(string $uuid_commande, iCatalogueService $catalogueService): CommandeDTO
    {
        if ($commande = Commande::find($uuid_commande)) {
            $itemsCommandes = $commande->items;
            $itemDTO = [];
            foreach ($itemsCommandes as $item) {
                $idCommande = $item->commande_id;
                $produit = $catalogueService->recupererProduit($item->numero);
                $itemDTO[] = new ItemDTO(
                    $item->id,
                    $idCommande,
                    $item->numero,
                    $item->quantite,
                    $produit->getPrix(),
                    $produit->getLibelle(),
                    $item->taille,
                    $produit->getLibelleTaille($item->taille));
            }
        } else {
            throw new ServiceCommandeNotFoundException("Commande not found", 404);
        }
        return new CommandeDTO(
            $commande->id,
            $commande->date_commande,
            $commande->type_livraison,
            $commande->delai,
            $commande->etat,
            $commande->montant_total,
            $commande->mail_client,
            $itemDTO);
    }

    /**
     * @throws ServiceCommandeNotFoundException
     */
    public function validerCommande(string $uuid_commande)
    {
        if ($commande = Commande::find($uuid_commande)) {
            $items_commande = Item::where('commande_id', $commande->id)->get();
            $commandeValide = true;
            if ($commande->etat != Commande::ETAT_VALIDE) {
                if ($commande->mail_client == "" || filter_var($commande->mail_client, FILTER_VALIDATE_EMAIL) === false) {
                    $commandeValide = false;
                } else if ($commande->type_livraison == null || ($commande->type_livraison != Commande::LIVRAISON_SUR_PLACE && $commande->type_livraison != Commande::LIVRAISON_A_EMPORTER && $commande->type_livraison != Commande::LIVRAISON_A_DOMICILE)) {
                    $commandeValide = false;
                }
                else if (count($items_commande) != 0) {
                    $nb_items = count($items_commande);
                    $i = 0;
                    $item = $items_commande[0];
                    while ($commandeValide == true && $item != null && $i < $nb_items) {
                        if ($item->numero == null || $item->numero < 0 || !is_int($item->numero)) {
                            $commandeValide = false;
                        } else if ($item->quantite== null || $item->quantite < 0 || !is_int($item->quantite)) {
                            $commandeValide = false;
                        } else if ($item->taille == null || ($item->taille != Taille::NORMALE && $item->taille != Taille::GRANDE)) {
                            $commandeValide = false;
                        }
                        $i++;
                        $item = $items_commande[$i];
                    }
                }
                if ($commandeValide) {
                    $commande->etat = Commande::ETAT_VALIDE;
                } else {
                    $commande->etat = Commande::ETAT_CREE;
                }
                $commande->save();
            }

        } else {
            throw new ServiceCommandeNotFoundException("Commande not found", 404);
        }
    }

    /**
     * @throws ServiceCommandeNotFoundException
     */
    public
    function creerCommande(CommandeDTO $commandeDTO, iCatalogueService $catalogueService): CommandeDTO
    {
        try {
            $validator = v::arrayType()
                ->key('type_livraison', v::in(['livraison_express', 'livraison_standard']))
                ->key('delai', v::date('Y-m-d H:i:s'))
                ->key('items', v::notEmpty()->each(
                    v::key('numero', v::intVal()->positive())
                        ->key('quantite', v::intVal()->positive())
                        ->key('taille', v::in(['petite', 'moyenne', 'grande']))
                ));
            $validator->assert($commandeDTO->toArray());

            $identifiantCommande = uniqid();
            $dateCommande = date("Y-m-d H:i:s");
            $etatCommande = Commande::ETAT_CREE;
            $itemsCommandes = $commandeDTO->getItems();
            $montantCommande = 0;
            foreach ($itemsCommandes as $item) {
                $produit = $catalogueService->recupererProduit($item->getNumero());
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
        } catch (ValidationException $e) {
            throw new ServiceCommandeNotFoundException("Commande not found", 404);
        }
    }

    public
    function loggin(CommandeDTO $commandeDTO): CommandeDTO
    {
        $logger = new Logger('Commande');
        $logger->pushHandler(new StreamHandler('Commande.log', Logger::INFO));
        $logger->info('Commande créée', ['id' => $commandeDTO->getIdCommande()]);
        return $commandeDTO;
    }

}

