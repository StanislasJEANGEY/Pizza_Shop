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

    //creerCommande()
    $app->post('/commandes[/]', pizzashop\shop\app\actions\post\CreerCommande::class)
        ->setName('post-creer_commande');

    // authentification signin
    $app->post('/auth/signin[/]', pizzashop\shop\app\actions\post\AuthentificationSingin::class)
        ->setName('post-authentification-signin');

    // authentification validate
    $app->get('/auth/validate[/]', pizzashop\shop\app\actions\get\AuthentificationValidate::class)
        ->setName('get-authentification-validate');

    // authentification refresh
    $app->post('/auth/refresh[/]', pizzashop\shop\app\actions\post\AuthentificationRefresh::class)
        ->setName('post-authentification-refresh');

    // catalog listerProduits
    $app->get('/produits[/]', pizzashop\shop\app\actions\get\ListerProduits::class)
        ->setName('get-lister_produits');

    // catalog accederProduit
    $app->get('/produits/{id}', \pizzashop\shop\app\actions\get\AccederProduit::class)
        ->setName('get-acceder_produit');

    //todo jules add route
};