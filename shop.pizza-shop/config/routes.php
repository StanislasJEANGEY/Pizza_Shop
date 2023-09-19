<?php
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

return function( \Slim\App $app):void {

    $app->get('/', \pizzashop\shop\app\actions\get\Accueil::class)
        ->setName('accueil');

    $app->post('/commandes[/]', \pizzashop\shop\shop\app\actions\CreerCommandeAction::class)
        ->setName('creer_commande');

    $app->get('/commandes/{id_commande}[/]', \pizzashop\shop\shop\app\actions\AccederCommandeAction::class)
        ->setName('commande');
};