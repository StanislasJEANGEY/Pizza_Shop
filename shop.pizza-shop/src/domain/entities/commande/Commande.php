<?php

namespace pizzashop\shop\domain\entities\commande;
use pizzashop\shop\domain\dto\commande\CommandeDTO;

class Commande extends \Illuminate\Database\Eloquent\Model {

    protected $connection = 'commande';
    protected $table = 'commande';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['delai', 'date_commande', 'type_livraison', 'etat', 'montant_total', 'mail_client'];

    const ETAT_CREE = 1;
    const ETAT_VALIDE = 2;
    const ETAT_PAYE = 3;
    const ETAT_LIVRE = 4;

    const LIVRAISON_SUR_PLACE  = 1;
    const LIVRAISON_A_EMPORTER = 2;
    const LIVRAISON_A_DOMICILE = 3;

    public function items(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Item::class, 'commande_id');
    }

    public function toDTO(array $items_commande = []): CommandeDTO
    {
        return new CommandeDTO(
            $this->id,
            $this->date_commande,
            $this->type_livraison,
            $this->delai,
            $this->montant_total,
            $this->mail_client,
            $items_commande
        );
    }
}