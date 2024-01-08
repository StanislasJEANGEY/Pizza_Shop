<?php

use Illuminate\Database\Capsule\Manager as Eloquent;
use Slim\Factory\AppFactory;

$dep = require_once __DIR__ . '/container.php';

$builder = new DI\ContainerBuilder();
$builder->addDefinitions($dep);
$c = $builder->build();

$app = AppFactory::createFromContainer($c);

$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, false, false);

return $app;
