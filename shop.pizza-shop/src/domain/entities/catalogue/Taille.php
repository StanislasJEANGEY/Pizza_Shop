<?php

namespace pizzashop\shop\domain\entities\catalogue;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use pizzashop\shop\domain\dto\catalogue\TailleDTO;

class Taille extends \Illuminate\Database\Eloquent\Model
{

    const NORMALE = 1;
    const GRANDE = 2;
	
    protected $connection = 'catalog';
    protected $table = 'taille';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [ 'libelle'];

    public function produits() : BelongsToMany {
        return $this->belongsToMany(Produit::class, 'tarif', 'taille_id', 'produit_id');
    }

    public function tarifs() : BelongsToMany {
        return $this->belongsToMany(Produit::class, 'tarif', 'taille_id', 'produit_id')
            ->withPivot('tarif');
    }

    public function toDTO(){
        return new TailleDTO(
            $this->id,
            $this->libelle
        );
    }

}