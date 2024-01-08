<?php

namespace pizzashop\gateway\action;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ListerProduits extends AbstractAction
{

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        try {
            return $this->container->get('guzzle')->get('/produits');
        }catch (\Exception $e) {
            $data = $this->exception($e);
            $data = $this->formatJSON($data);
            $response->getBody()->write($data);
            return $response->withHeader('Content-Type', 'application/json')
                ->withStatus($e->getCode());
        }
    }
}