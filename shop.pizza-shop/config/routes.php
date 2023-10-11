<?php
declare(strict_types=1);


use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

return function( \Slim\App $app):void {

    $app->get('/', \pizzashop\shop\app\actions\get\Accueil::class)
        ->setName('get-accueil');

    $app->get('/commandes/{id_commande}', pizzashop\shop\app\actions\get\Commande::class)
        ->setName('get-commande');


};