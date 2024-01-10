<?php

namespace pizzashop\gateway\action;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class FiltrerProduits extends AbstractAction
{

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        return $this->requeteGuzzle('GET', $this->container->get('link_shop').'/produits/search/'. $args['keyword'], $request, $response);
    }
}