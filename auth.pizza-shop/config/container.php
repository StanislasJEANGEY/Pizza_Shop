<?php

use pizzashop\shop\app\actions\get\AccederCommande;
use pizzashop\shop\app\actions\patch\ValiderCommande;
use pizzashop\shop\domain\service\CatalogueService;
use pizzashop\shop\domain\service\CommandeService;
use Psr\Container\ContainerInterface;

$secret = 'secret';

return [

    'jwtmanager' => function(ContainerInterface $container) {
        return new CommandeService('secret', 3600);
    },

];