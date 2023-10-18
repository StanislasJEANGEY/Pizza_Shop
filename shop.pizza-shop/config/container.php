<?php

return [
    'commande.service' => function() {
        return new \pizzashop\shop\domain\service\CommandeService();
    },

    \pizzashop\shop\app\actions\get\AccederCommande::class => function(\Psr\Container\ContainerInterface $container) {
        $service = $container->get('commande.service');
        return new \pizzashop\shop\app\actions\get\AccederCommande($service);
    },

];