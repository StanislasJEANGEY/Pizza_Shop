<?php
declare(strict_types=1);


use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

return function( \Slim\App $app):void {

    // CORS
    $app->add(function (Request $request, $handler) {
        $response = $handler->handle($request);
        return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    });

    // Accueil
    $app->get('[/]', \pizzashop\shop\app\actions\get\Accueil::class)
        ->setName('get-accueil');

    // accederCommande()
    $app->get('/commandes/{id_commande}', pizzashop\shop\app\actions\get\AccederCommande::class)
        ->setName('get-acceder_commande');

    // validerCommande()
    $app->patch('/commandes/{id_commande}', pizzashop\shop\app\actions\patch\ValiderCommande::class)
        ->setName('patch-valider_commande');

    $app->post('/commandes[/]', pizzashop\shop\app\actions\post\CreerCommande::class)
        ->setName('post-creer_commande');
};