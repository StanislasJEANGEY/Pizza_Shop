<?php

namespace pizzaShop\shop\domain\entities\commande;
class Commande extends \Illuminate\Database\Eloquent\Model {

    protected $connection = 'shop';
    protected $table = 'commande';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [ 'delai', 'date_commande', 'type_livraison', 'etat', 'montant_total', 'mail_client'];

    public function items()
    {
        return $this->hasMany(Item::class, 'commande_id');
    }
}