<?php

namespace pizzashop\shop\domain\dto\catalogue;

use pizzashop\shop\domain\dto\DTO;

class CategorieDTO extends DTO {
    public int $numero_categorie;
    public string $libelle_categorie;

    public function __construct(int $numero_categorie, string $libelle_categorie) {
        $this->numero_categorie = $numero_categorie;
        $this->libelle_categorie = $libelle_categorie;
    }
}