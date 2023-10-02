<?php

namespace pizzaShop\shop\domain\entities\commande;
class Commande extends \Illuminate\Database\Eloquent\Model {

    protected $connection = 'shop';
    protected $table = 'commande';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['delai', 'date_commande', 'type_livraison', 'etat', 'montant_total', 'mail_client'];

    const ETAT_CREE = 1;
    const ETAT_VALIDE = 2;
    const ETAT_PAYE = 3;
    const ETAT_LIVRE = 4;

    const LIVRAISON_SUR_PLACE = 1;
    const LIVRAISON_A_EMPORTER = 2;
    const LIVRAISON_A_DOMICILE = 3;

    public function items()
    {
        return $this->hasMany(Item::class, 'commande_id');
    }
}