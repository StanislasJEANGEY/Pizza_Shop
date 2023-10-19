<?php

use pizzashop\shop\app\actions\get\AccederCommande;
use pizzashop\shop\app\actions\patch\ValiderCommande;
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

    /* lien local */
    'link' => 'http://localhost:18070/',
    /* lien prod */
    //'link' => 'https://docketu.iutnc.univ-lorraine.fr:18070/',

    AccederCommande::class => function(ContainerInterface $container) {
        return new AccederCommande($container,$container->get('commande.service'));
    },

    ValiderCommande::class => function(ContainerInterface $container) {
        return new ValiderCommande($container,$container->get('commande.service'));
    },

    CreerCommande::class => function(ContainerInterface $container) {
        return new CreerCommande($container,$container->get('commande.service'));
    },

];