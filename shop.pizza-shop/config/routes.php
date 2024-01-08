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

    $app->post('/auth/singin[/]', pizzashop\shop\app\actions\post\AuthentificationSingin::class)
        ->setName('post-authentification-signin');

    $app->get('/auth/validate[/]', pizzashop\shop\app\actions\get\AuthentificationValidate::class)
        ->setName('get-authentification-validate');

    $app->post('/auth/refresh[/]', pizzashop\shop\app\actions\post\AuthentificationRefresh::class)
        ->setName('post-authentification-refresh');

    $app->get('/listerProduits[/]', pizzashop\shop\app\actions\get\ListerProduits::class)
        ->setName('get-lister_produits');

};