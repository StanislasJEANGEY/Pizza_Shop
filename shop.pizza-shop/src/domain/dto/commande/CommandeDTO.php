<?php
namespace pizzashop\shop\shop\domain\dto\commande;

use pizzashop\shop\shop\domain\dto\DTO;

class CommandeDTO extends DTO{

    public int $numero_commande;
    public string $date_commande;
    public int $type_livraison;
    public int $delai_commande;
    public int $etat_commande;
    public float $montant_commande;
    public string $mail_client;

    public function __construct(int $numero_commande, string $date_commande, int $type_livraison, int $delai_commande, int $etat_commande, float $montant_commande, string $mail_client)
    {
        $this->numero_commande = $numero_commande;
        $this->date_commande = $date_commande;
        $this->type_livraison = $type_livraison;
        $this->delai_commande = $delai_commande;
        $this->etat_commande = $etat_commande;
        $this->montant_commande = $montant_commande;
        $this->mail_client = $mail_client;
    }

}