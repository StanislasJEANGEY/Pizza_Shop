<?php

use pizzashop\shop\app\actions\get\AccederCommande;
use pizzashop\shop\app\actions\get\AccederProduit;
use pizzashop\shop\app\actions\get\ListerProduits;
use pizzashop\shop\app\actions\patch\ValiderCommande;
use pizzashop\shop\app\actions\post\AuthentificationSingin;
use pizzashop\shop\app\actions\post\CreerCommande;
use pizzashop\shop\domain\service\CatalogueService;
use pizzashop\shop\domain\service\CommandeService;
use Psr\Container\ContainerInterface;

return [
    'guzzle' => function(ContainerInterface $container) {
        return new GuzzleHttp\Client(
            [
                'base_uri' => 'http://api.pizza-shop',
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ]
            ]
        );
    },


];