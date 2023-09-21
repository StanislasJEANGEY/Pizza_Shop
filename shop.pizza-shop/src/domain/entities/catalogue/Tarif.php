<?php

namespace pizzashop\shop\domain\entities\catalogue;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tarif extends \Illuminate\Database\Eloquent\Model {

    protected $connection = 'catalog';
    protected $table = 'tarif';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['produit_id', 'taille_id', 'tarif'];

    public function produit() : BelongsTo {
        return $this->belongsTo(Produit::class, 'produit_id');
    }

    public function taille() : BelongsTo {
        return $this->belongsTo(Taille::class, 'taille_id');
    }

}