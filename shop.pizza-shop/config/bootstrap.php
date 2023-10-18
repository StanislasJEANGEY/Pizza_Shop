<?php

use Illuminate\Database\Capsule\Manager as Eloquent;
use Slim\Factory\AppFactory;

$dep = require_once __DIR__ . '/container.php';

$builder = new DI\ContainerBuilder();
$builder->addDefinitions($dep);
$c = $builder->build();

$app = AppFactory::createFromContainer($c);

$eloquent = new Eloquent();
$eloquent->addConnection(parse_ini_file(__DIR__ . '/commande.db.ini'), 'commande');
$eloquent->addConnection(parse_ini_file(__DIR__ . '/catalog.db.ini'), 'catalog');
$eloquent->setAsGlobal();
$eloquent->bootEloquent();

$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, false, false);

return $app;
