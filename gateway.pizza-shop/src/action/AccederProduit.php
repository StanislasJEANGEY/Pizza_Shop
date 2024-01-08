<?php

namespace pizzashop\gateway\action;

use pizzashop\gateway\action\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AccederProduit extends AbstractAction
{

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        try{
            return $this->container->get('guzzle')->get('/produits/' . $args['id']);

        } catch (\Exception $e){
            $data = $this->exception($e);
            $status = $e->getCode();
            $data = $this->formatJSON($data);
            $response->getBody()->write($data);
            return $response->withHeader('Content-Type', 'application/json')
                ->withStatus($status);
        }
    }
}