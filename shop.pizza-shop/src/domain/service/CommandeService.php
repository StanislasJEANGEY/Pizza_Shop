<?php

namespace pizzashop\shop\domain\service;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use pizzashop\shop\domain\dto\commande\CommandeDTO;
use pizzashop\shop\domain\dto\commande\ItemDTO;
use pizzashop\shop\domain\entities\commande\Commande;
use pizzashop\shop\Exception\ServiceCommandeNotFoundException;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validator as v;

class CommandeService implements iCommandeService
{

    /**
     * @throws ServiceCommandeNotFoundException
     */
    public function accederCommande(string $uuid_commande, iCatalogueService $catalogueService) : CommandeDTO
    {
        if ($commande = Commande::find($uuid_commande)) {
            $itemsCommandes = $commande->items;
            $itemDTO = [];
            foreach ($itemsCommandes as $item) {
                $produit = $catalogueService->recupererProduit($item->numero);
                $itemDTO[] = new ItemDTO(
                    $item->id,
                    $item->id_commande,
                    $item->numero,
                    $item->quantite,
                    $produit->getPrix(),
                    $produit->getLibelle(),
                    $item->taille,
                    $item->taille);
            }
        } else {
            throw new ServiceCommandeNotFoundException("Commande not found", 404);
        }
        return new CommandeDTO(
            $commande->id,
            $commande->date_commande,
            $commande->type_livraison,
            $commande->delai_commande,
            $commande->etat_commande,
            $commande->montant_commande,
            $commande->mail_client,
            $itemDTO);
    }

    /**
     * @throws ServiceCommandeNotFoundException
     */
    public function validerCommande(string $uuid_commande) : CommandeDTO
    {
        if ($commande = Commande::find($uuid_commande)) {
            $commande->etat_commande = Commande::ETAT_VALIDE;
            $commande->save();
            return new CommandeDTO(
                $commande->id,
                $commande->date_commande,
                $commande->type_livraison,
                $commande->delai_commande,
                $commande->etat_commande,
                $commande->montant_commande,
                $commande->mail_client,
                $commande->items_commande);
        } else {
            throw new ServiceCommandeNotFoundException("Commande not found", 404);
        }
    }

    /**
     * @throws ServiceCommandeNotFoundException
     */
    public function creerCommande(CommandeDTO $commandeDTO, iCatalogueService $catalogueService) : CommandeDTO
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

    public function loggin(CommandeDTO $commandeDTO) : CommandeDTO
    {
        $logger = new Logger('Commande');
        $logger->pushHandler(new StreamHandler('Commande.log', Logger::INFO));
        $logger->info('Commande créée', ['id' => $commandeDTO->getIdCommande()]);
        return $commandeDTO;
    }

}

