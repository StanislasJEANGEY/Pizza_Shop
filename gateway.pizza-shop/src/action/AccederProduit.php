<?php

namespace pizzashop\gateway\action;

use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AccederProduit extends AbstractAction
{

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        return $this->requeteGuzzle('GET', $this->container->get('link_shop').'/produits/' . $args['id'], $request, $response);
    }
}