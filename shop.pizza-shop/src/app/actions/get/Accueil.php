<?php

namespace pizzashop\shop\app\actions\get;

use pizzashop\shop\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Accueil extends AbstractAction
{
    function __invoke(Request $request, Response $response, array $args): Response
    {
        $response->getBody()->write('Hello world!');
        return $response->withStatus(200)->withHeader('Content-Type', 'text/html');
    }
}