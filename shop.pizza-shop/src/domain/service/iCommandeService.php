<?php

namespace pizzashop\shop\domain\service;

use pizzashop\shop\domain\dto\commande\CommandeDTO;

interface iCommandeService {
    public function accederCommande(string $uuid_commande): CommandeDTO;
    public function validerCommande(string $uuid_commande);

    public function creerCommande(CommandeDTO $commandeDTO);
}