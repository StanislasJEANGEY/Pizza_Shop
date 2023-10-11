<?php

namespace pizzashop\shop\domain\service;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use pizzashop\shop\domain\dto\commande\CommandeDTO;
use pizzashop\shop\domain\dto\commande\ItemDTO;
use pizzashop\shop\domain\entities\catalogue\Taille;
use pizzashop\shop\domain\entities\commande\Commande;
use pizzashop\shop\domain\entities\commande\Item;
use pizzashop\shop\Exception\ServiceCatalogueNotFoundException;
use pizzashop\shop\Exception\ServiceCommandeNotFoundException;
use pizzashop\shop\Exception\ServiceValidatorException;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validator as v;

class CommandeService implements iCommandeService
{

    /**
     * @throws ServiceCatalogueNotFoundException
     * @throws ServiceCommandeNotFoundException
     */
    public function accederCommande(string $uuid_commande): CommandeDTO
    {
        $catalogueService = new CatalogueService();
        if ($commande = Commande::find($uuid_commande)) {
            $itemEntitiessCommandes = $commande->items;
            $itemEntitiesDTO = [];
            foreach ($itemEntitiessCommandes as $itemEntities) {
                $produit = $catalogueService->recupererProduit($itemEntities->numero);
                $itemEntitiesDTO[] = new ItemDTO(
                    $itemEntities->commande_id,
                    $itemEntities->numero,
                    $itemEntities->quantite,
                    $produit->getPrix(),
                    $produit->getLibelle(),
                    $itemEntities->taille,
                    $produit->getLibelleTaille($itemEntities->taille));
            }
        } else {
            throw new ServiceCommandeNotFoundException("Commande not found", 404);
        }
        return new CommandeDTO(
            $commande->id,
            $commande->date_commande,
            $commande->type_livraison,
            $commande->delai,
            $commande->montant_total,
            $commande->mail_client,
            $itemEntitiesDTO);
    }

    /**
     * @throws ServiceCommandeNotFoundException
     * @throws ValidationException
     * @throws ServiceValidatorException
     */

    public function validerCommande(string $uuid_commande): void
    {
        if ($commande = Commande::find($uuid_commande)) {
            $itemEntitiess = Item::where('commande_id', $commande->id)->get();
            $tab_items = [];
            foreach ($itemEntitiess as $item) {
                $tab_items[] = $item->toDTO();
            }
            $commandeDTO = $commande->toDTO($tab_items);
            $commandeValide = true;

            try {
                if ($commande->etat != Commande::ETAT_VALIDE) {
                    v::attribute('mail_client', v::notEmpty()->email())
                        ->attribute('type_livraison', v::notEmpty()->in([1, 2, 3]))
                        ->attribute('items_commande', v::notEmpty()->arrayVal()
                            ->each(
                                v::attribute('numero_produit', v::notEmpty()->intVal()->positive())
                                ->attribute('quantite_items', v::notEmpty()->intVal()->positive())
                                ->attribute('taille_items', v::notEmpty()->in([1, 2]))
                            ))
                        ->assert($commandeDTO);

                    if ($commandeValide) {
                        $commande->etat = Commande::ETAT_VALIDE;
                    } else {
                        $commande->etat = Commande::ETAT_CREE;
                    }
                    $commande->save();
                }
            } catch (ValidationException $e) {
                throw new ServiceValidatorException($e->getFullMessage(), 500);
            }

        } else {
            throw new ServiceCommandeNotFoundException("Commande not found", 404);
        }
    }


    /**
     * @throws ServiceCommandeNotFoundException
     * @throws ServiceValidatorException
     */
    public
    function creerCommande(CommandeDTO $commandeDTO): void
    {
        try {
            $validator = v::attribute('mail_client', v::notEmpty()->email())
                ->attribute('type_livraison', v::notEmpty()->in([1, 2, 3]))
                ->attribute('items_commande', v::notEmpty()->arrayVal()
                    ->each(
                        v::attribute('numero_produit', v::notEmpty()->intVal()->positive())
                            ->attribute('quantite_items', v::notEmpty()->intVal()->positive())
                            ->attribute('taille_items', v::notEmpty()->in([1, 2]))
                    ));
            $validator->assert($commandeDTO);

            if ($commandeDTO->getIdCommande() != "" && $commandeDTO->getIdCommande() != null)
                $itemdentifiantCommande = $commandeDTO->getIdCommande();
            else $itemdentifiantCommande = uniqid();

            $montantCommande = 0;
            foreach ($commandeDTO->getItems() as $item) {
                $sousTotal = $item->getTarifItems() * $item->getQuantiteItems();
                $montantCommande += $sousTotal;
                
                //ajout de l'item en base
                $itemEntities = new Item();
                $itemEntities->numero = $item->getNumeroProduit();
                $itemEntities->libelle = $item->getLibelleItems();
                $itemEntities->taille = $item->getTailleItems();
                $itemEntities->libelle_taille = $item->getLibelleTaille();
                $itemEntities->tarif = $item->getTarifItems();
                $itemEntities->quantite = $item->getQuantiteItems();
                $itemEntities->commande_id = $itemdentifiantCommande;
                $itemEntities->save();
            }
            $commande = new Commande();
            $commande->id = $itemdentifiantCommande;
            $commande->delai = 0;
            $commande->date_commande = date("Y-m-d H:i:s");
            $commande->type_livraison = $commandeDTO->getTypeLivraison();
            $commande->etat = Commande::ETAT_CREE;;
            $commande->montant_total = $montantCommande;
            $commande->mail_client = $commandeDTO->getMailClient();
            $commande->save();


        } catch (ValidationException $e) {
            throw new ServiceValidatorException("Validation incorrecte", 500);
        }
    }

    public function loggin(CommandeDTO $commandeDTO): CommandeDTO
    {
        $logger = new Logger('Commande');
        $logger->pushHandler(new StreamHandler('Commande.log', Logger::INFO));
        $logger->info('Commande créée', ['id' => $commandeDTO->getIdCommande()]);
        return $commandeDTO;
    }

}

