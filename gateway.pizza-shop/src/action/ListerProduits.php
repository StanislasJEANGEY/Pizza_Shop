<?php

namespace pizzashop\gateway\action;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ListerProduits extends AbstractAction
{

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $guzzle = $this->container->get('guzzle');
        $res = $guzzle->get('/produits');
        $res = $res->getBody()->getContents();
        $response->getBody()->write($res);
        return $response;
    }
}