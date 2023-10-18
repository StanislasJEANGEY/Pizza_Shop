<?php

namespace pizzashop\shop\app\actions\get;

use pizzashop\shop\app\actions\AbstractAction;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Accueil extends AbstractAction
{
    function __invoke(Request $request, Response $response, array $args): Response
    {
        $data = [
            "API" => "Cette API est l'API de notre projet de PizzaShop",
            "links" => [
                [
                    "href" => $this->container->get('link') . '/commandes/{id-commande}',
                    "method" => "GET",
                    "description" => "Récupère les informations d'une commande."
                ],
                [
                    "href" => $this->container->get('link') . '/commandes/{id-commande}',
                    "method" => "PATCH",
                    "body" => "{ etat: validée }",
                    "description" => "Valide une commande quand le body de la requête."
                ],
                [
                    "href" => $this->container->get('link') . '/commandes',
                    "method" => "POST",
                    "body" => "CommandeDTO sous forme de JSON",
                    "description" => "Crée une commande."
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