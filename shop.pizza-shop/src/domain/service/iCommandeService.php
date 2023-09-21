<?php

namespace pizzashop\shop\domain\service;

use pizzashop\shop\shop\domain\dto\commande\CommandeDTO;

interface iCommandeService {
    public function accederCommande(string $uuid_commande): CommandeDTO;
    public function validerCommande(array $uuid_commande): CommandeDTO;
}