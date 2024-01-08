<?php

use pizzashop\shop\app\actions\get\AccederCommande;
use pizzashop\shop\app\actions\get\ListerProduits;
use pizzashop\shop\app\actions\patch\ValiderCommande;
use pizzashop\shop\app\actions\post\AuthentificationSingin;
use pizzashop\shop\app\actions\post\CreerCommande;
use pizzashop\shop\domain\service\CatalogueService;
use pizzashop\shop\domain\service\CommandeService;
use Psr\Container\ContainerInterface;

return [
    'commande.service' => function(ContainerInterface $container) {
        return new CommandeService($container->get('catalogue.service'));
    },

    'catalogue.service' => function() {
        return new CatalogueService();
    },

    /* lien local api shop*/
    'link' => 'http://localhost:18070/',


    /* lien local api auth*/
    'link_auth' => 'http://api.pizza-auth/',


    'guzzle' => function(ContainerInterface $container) {
        return new GuzzleHttp\Client();
    },

    AccederCommande::class => function(ContainerInterface $container) {
        return new AccederCommande($container,$container->get('commande.service'));
    },

    ValiderCommande::class => function(ContainerInterface $container) {
        return new ValiderCommande($container,$container->get('commande.service'));
    },

    CreerCommande::class => function(ContainerInterface $container) {
        return new CreerCommande($container,$container->get('commande.service'));
    },

    AuthentificationSingin::class => function(ContainerInterface $container) {
        return new AuthentificationSingin($container,);
    },

    ListerProduits::class => function(ContainerInterface $container) {
        return new ListerProduits($container,$container->get('catalogue.service'));
    },

];