<?php

namespace pizzashop\shop\app\actions\get;

use pizzashop\shop\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Accueil extends AbstractAction
{
    function __invoke(Request $request, Response $response, array $args): Response
    {
//        $link = "http://docketu.iutnc.univ-lorraine.fr:18070";
        $link = "http://pizzashop/";
        $data = [
            "API" => "Cette API est l'API de notre projet de PizzaShop",
            "links" => [
                [
                    "href" => $link . '/commandes/{id-commande}',
                    "method" => "GET",
                    "description" => "Récupère les informations d'une commande."
                ]
            ],
            [
                "API" => "Cette API est l'API de notre projet de PizzaShop",
                "links" => [
                    [
                        "href" => $link . '/commandes/{id-commande}',
                        "method" => "PATCH",
                        "description" => "Valide une commande."
                    ]
                ]
            ]
        ];

        $data = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $data = str_replace('\/', '/', $data);

        $response->getBody()->write($data);
        return $response->withHeader('Content-Type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withStatus(200);
    }
}