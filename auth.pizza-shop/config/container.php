<?php

use pizzashop\auth\api\domain\service\utils\JWTManager;
use pizzashop\shop\app\actions\get\AccederCommande;
use pizzashop\shop\app\actions\patch\ValiderCommande;
use pizzashop\shop\domain\service\CatalogueService;
use pizzashop\shop\domain\service\CommandeService;
use Psr\Container\ContainerInterface;


return [

    'jwtmanager' => function(ContainerInterface $container) {
                return new JWTManager('secretKey', 604800 /*1 semaine */);
    },

];