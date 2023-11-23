<?php
declare(strict_types=1);


use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

return function( \Slim\App $app):void {

    // Accueil
    $app->get('[/]', \pizzashop\auth\api\app\action\get\Accueil::class)
        ->setName('get-accueil');
    $app->post('/signin', \pizzashop\auth\api\app\action\post\SigninAction::class)
        ->setName('post-signin');
    $app->get('/validate', \pizzashop\auth\api\app\action\get\ValidateAction::class)
        ->setName('get-validate');
    $app->post('/refresh', \pizzashop\auth\api\app\action\post\RefreshAxvalidatection::class)
        ->setName('post-refresh');
};