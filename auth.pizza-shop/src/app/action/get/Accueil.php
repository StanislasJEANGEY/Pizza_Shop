<?php

namespace pizzashop\auth\api\app\action\get;

use pizzashop\auth\api\app\action\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Accueil extends AbstractAction
{

    function __invoke(Request $request, Response $response, array $args): Response
    {
        $data = [
            "API" => "Cette API est l'API d'authentification de notre projet de PizzaShop",
        ];

        $data = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $data = str_replace('\/', '/', $data);

        $response->getBody()->write($data);
        return $response->withHeader('Content-Type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withStatus(200);
    }
}