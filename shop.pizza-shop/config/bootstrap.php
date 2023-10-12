<?php

use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as Eloquent;
use Slim\Factory\AppFactory as Factory;
use pizzashop\shop\app\actions\get\AccederCommande;

$app = Factory::create();

$container = new Container();
Factory::setContainer($container);

$eloquent = new Eloquent();
$eloquent->addConnection(parse_ini_file(__DIR__ . '/commande.db.ini'), 'commande');
$eloquent->addConnection(parse_ini_file(__DIR__ . '/catalog.db.ini'), 'catalog');
$eloquent->setAsGlobal();
$eloquent->bootEloquent();

$container->bind('commande.service', function () {
    return new AccederCommande();
});

$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, false, false);

return $app;
