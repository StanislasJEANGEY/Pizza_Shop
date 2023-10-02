<?php
namespace pizzashop\shop\domain\dto\commande;

use pizzashop\shop\domain\dto\DTO;

/**
 * @method getTypeLivraison()
 * @method getDelai()
 * @method getMailClient()
 * @method getItems()
 * @method getIdCommande()
 * @method toArray()
 */
class CommandeDTO extends DTO{

    public int $id_commande;
    public string $date_commande;
    public int $type_livraison;
    public int $delai_commande;
    public int $etat_commande;
    public float $montant_commande;
    public string $mail_client;
    public array $items_commande;

    public function __construct(int $id_commande, string $date_commande, int $type_livraison, int $delai_commande, int $etat_commande, float $montant_commande, string $mail_client)
    {
        $this->id_commande = $id_commande;
        $this->date_commande = $date_commande;
        $this->type_livraison = $type_livraison;
        $this->delai_commande = $delai_commande;
        $this->etat_commande = $etat_commande;
        $this->montant_commande = $montant_commande;
        $this->mail_client = $mail_client;
    }

}