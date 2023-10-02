<?php

namespace pizzashop\shop\domain\entities\catalogue;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use pizzashop\shop\domain\dto\catalogue\TarifDTO;

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

    public function toDTO(){
        return new TarifDTO(
            $this->produit_id,
            $this->taille_id,
            $this->tarif
        );
    }

}