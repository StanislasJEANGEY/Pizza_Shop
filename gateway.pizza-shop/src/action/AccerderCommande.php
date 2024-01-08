<?php

namespace pizzashop\gateway\action;

use pizzashop\gateway\action\AbstractAction;


class AccerderCommande extends AbstractAction
{

    public function __invoke(\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Message\ResponseInterface $response, array $args): \Psr\Http\Message\ResponseInterface
    {
        try {
            return $this->container->get('guzzle')->get('/commandes/' . $args['id'], [
                'headers' => [
                    'Authorization' => $request->getHeaderLine('Authorization')
                ]
            ]);
        } catch (\Exception $e) {
            $data = $this->exception($e);
            $status = $e->getCode();
            $data = $this->formatJSON($data);
            $response->getBody()->write($data);
            return $response->withHeader('Content-Type', 'application/json')
                ->withStatus($status);
        }
    }

}