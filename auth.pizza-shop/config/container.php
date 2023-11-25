<?php

use pizzashop\auth\api\domain\service\utils\JWTManager;
use pizzashop\shop\app\actions\get\AccederCommande;
use pizzashop\shop\app\actions\patch\ValiderCommande;
use pizzashop\shop\domain\service\CatalogueService;
use pizzashop\shop\domain\service\CommandeService;
use Psr\Container\ContainerInterface;


return [

    'jwtmanager' => function(ContainerInterface $container) {
        $var = getenv('SECRET_KEY');
        if ($var === false) {
            throw new Exception('Secret key not found');
        } else if (is_array($var)) {
            throw new Exception('Secret key is not a string');
        } else $secret = $var;

        return new JWTManager($secret, 3600);
    },

];