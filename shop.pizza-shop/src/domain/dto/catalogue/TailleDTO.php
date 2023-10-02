<?php

namespace pizzashop\shop\domain\dto\catalogue;

class TailleDTO
{
    public int $id;
    public string $libelle;

    /**
     * @param int $id
     * @param string $libelle
     */
    public function __construct(int $id, string $libelle)
    {
        $this->id = $id;
        $this->libelle = $libelle;
    }
}