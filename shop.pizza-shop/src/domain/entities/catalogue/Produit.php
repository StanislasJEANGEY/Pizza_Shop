<?php

namespace pizzashop\shop\domain\entities\catalogue;

use Illuminate\database\eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use pizzashop\shop\domain\dto\catalogue\ProduitDTO;

class Produit extends Model
{

    protected $connection = 'catalog';
    protected $table = 'produit';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['numero', 'libelle', 'description', 'image'];

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }

    public function tailles(): BelongsToMany
    {
        return $this->belongsToMany(Taille::class, 'tarif', 'produit_id', 'taille_id')
            ->withPivot('tarif');
    }

    public function tarifs(): BelongsToMany {
        return $this->belongsToMany(Taille::class, 'tarif', 'produit_id', 'taille_id')
            ->withPivot('tarif');
    }

    public function toDTO(): ProduitDTO
    {
        return new ProduitDTO(
            $this->numero,
            $this->libelle,
            $this->description,
            $this->categorie->libelle,
            $this->tailles->map(function ($taille) {
                return $taille->libelle;
            }),
            $this->tarifs->map(function ($tarif) {
                return $tarif->pivot->tarif;
            }),
            $this->image
        );
    }
}