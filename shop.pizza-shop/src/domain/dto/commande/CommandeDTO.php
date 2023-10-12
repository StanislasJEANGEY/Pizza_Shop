<?php
namespace pizzashop\shop\domain\dto\commande;

use pizzashop\shop\domain\dto\DTO;
use pizzashop\shop\domain\entities\commande\Commande;
use function FastRoute\cachedDispatcher;


class CommandeDTO extends DTO{

    private int $id_commande;
    private string $date_commande;
    private int $type_livraison;
    private int $delai_commande;
    private int $etat_commande;
    private float $montant_commande;
    private string $mail_client;
    private array $items_commande;


    public function __construct(int $id_commande, string $date_commande, int $type_livraison, int $delai_commande, int $etat_commande, float $montant_commande, string $mail_client, array $items_commande)
    {
        $this->id_commande = $id_commande;
        $this->date_commande = $date_commande;
        $this->type_livraison = $type_livraison;
        $this->delai_commande = $delai_commande;
        $this->etat_commande = $etat_commande;
        $this->montant_commande = $montant_commande;
        $this->mail_client = $mail_client;
        $this->items_commande = $items_commande;
    }

    public function getIdCommande(): int
    {
        return $this->id_commande;
    }

    public function getDateCommande(): string
    {
        return $this->date_commande;
    }

    public function getTypeLivraison(): int
    {
        return $this->type_livraison;
    }

    public function getDelaiCommande(): int
    {
        return $this->delai_commande;
    }

    public function getMontantCommande(): float
    {
        return $this->montant_commande;
    }

    public function getMailClient(): string
    {
        return $this->mail_client;
    }

    public function getItemsCommande(): array
    {
        return $this->items_commande;
    }

    public function getItems(): array
    {
        return $this->items_commande;
    }

    public function getEtatCommande(): String
    {
        switch ($this->etat_commande){
            case Commande::ETAT_CREE:
                return "Commande créée";
            case Commande::ETAT_VALIDE:
                return "Commande validée";
            case Commande::ETAT_PAYE:
                return "Commande payée";
            case Commande::ETAT_LIVRE:
                return "Commande livrée";
        }
    }




}