<?php

namespace pizzashop\shop\domain\entities\catalogue;

use pizzashop\shop\domain\dto\catalogue\CategorieDTO;

class Categorie extends \Illuminate\Database\Eloquent\Model
{

    protected $connection = 'catalog';
    protected $table = 'categorie';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [ 'libelle'];

    public function produits()
    {
        return $this->hasMany(Produit::class, 'categorie_id');
    }

    public function toDTO(): CategorieDTO
    {
        return new CategorieDTO(
            $this->id,
            $this->libelle
        );
    }

}