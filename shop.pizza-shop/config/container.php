<?php

return [
    'commande.service' => function(\Psr\Container\ContainerInterface $container) {
        return new \pizzashop\shop\domain\service\CommandeService();
    },


];