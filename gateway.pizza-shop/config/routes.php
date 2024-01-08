<?php
declare(strict_types=1);


use pizzashop\gateway\action\AccerderCommande;

return function(\Slim\App $app):void {
    // accederCommande()
    $app->get('/commandes/{id}',AccerderCommande::class)
        ->setName('get-acceder_commande');

    // validerCommande()
    $app->patch('/commandes/{id_commande}',\pizzashop\gateway\action\ValiderCommande::class)
        ->setName('patch-valider_commande');

    //creerCommande()
    $app->post('/commandes[/]',\pizzashop\gateway\action\CreerCommande::class)
        ->setName('post-creer_commande');

    // authentification signin
    $app->post('/auth/singin[/]',\pizzashop\gateway\action\AuthentificationSignin::class)
        ->setName('post-authentification-signin');

    // authentification validate
    $app->get('/auth/validate[/]',\pizzashop\gateway\action\AuthentificationValidate::class)
        ->setName('get-authentification-validate');

    // authentification refresh
    $app->post('/auth/refresh[/]',\pizzashop\gateway\action\AuthentificationRefresh::class)
        ->setName('post-authentification-refresh');

    // catalog listerProduits
    $app->get('/produits[/]',pizzashop\gateway\action\ListerProduits::class)
        ->setName('get-lister_produits');

    // catalog accederProduit
    $app->get('/produits/{id}',\pizzashop\gateway\action\AccederProduit::class)
        ->setName('get-acceder_produit');

};