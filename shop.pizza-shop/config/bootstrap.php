<?php


use pizzashop\shop\Eloquent;
use Slim\Factory\AppFactory as Factory;

$app = Factory::create();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, false, false);

Eloquent::init(__DIR__ . '/commande.db.ini');

return $app;