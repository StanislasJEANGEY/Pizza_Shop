<?php
declare(strict_types=1);


use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

return function( \Slim\App $app):void {

    // Accueil
    $app->get('[/]', \pizzashop\auth\api\app\action\get\Accueil::class)
        ->setName('get-accueil');
};