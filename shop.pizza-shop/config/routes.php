<?php
declare(strict_types=1);


use Psr\Http\Message\ServerRequestInterface as Request;

return function( \Slim\App $app):void {

    // CORS
    $app->add(function (Request $request, $handler) {
        $response = $handler->handle($request);
        return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    });

    // accederCommande()
    $app->get('/commandes/{id_commande}', pizzashop\shop\app\actions\get\AccederCommande::class)
        ->setName('get-acceder_commande');

    // validerCommande()
    $app->patch('/commandes/{id_commande}', pizzashop\shop\app\actions\patch\ValiderCommande::class)
        ->setName('patch-valider_commande');

    //creerCommande()
    $app->post('/commandes[/]', pizzashop\shop\app\actions\post\CreerCommande::class)
        ->setName('post-creer_commande');

    // catalog listerProduits
    $app->get('/produits[/]', pizzashop\shop\app\actions\get\ListerProduits::class)
        ->setName('get-lister_produits');

    // catalog accederProduit
    $app->get('/produits/{id}', pizzashop\shop\app\actions\get\AccederProduit::class)
        ->setName('get-acceder_produit');

    // catalog listerProduitsParCategorie
    $app->get('/categories/{id_categorie}/produits', pizzashop\shop\app\actions\get\ListerProduitsParCategorie::class)
        ->setName('get-lister_produits_par_categorie');
};