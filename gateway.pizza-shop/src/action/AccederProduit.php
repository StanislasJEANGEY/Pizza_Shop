<?php

namespace pizzashop\gateway\action;

use pizzashop\gateway\action\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AccederProduit extends AbstractAction
{

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $guzzle = $this->container->get('guzzle');
        $res = $guzzle->get('/produits/' . $args['id']);
        $res = $res->getBody()->getContents();
        $response->getBody()->write($res);
        return $response;
    }
}