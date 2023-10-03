<?php


use Illuminate\Database\Capsule\Manager as Eloquent;
use Slim\Factory\AppFactory as Factory;

$app = Factory::create();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, false, false);

$eloquent = new Eloquent();
$eloquent->addConnection(parse_ini_file(__DIR__ . '/commande.db.ini'), 'commande');
$eloquent->addConnection(parse_ini_file(__DIR__ . '/catalog.db.ini'), 'catalog');
$eloquent->setAsGlobal();
$eloquent->bootEloquent();

return $app;