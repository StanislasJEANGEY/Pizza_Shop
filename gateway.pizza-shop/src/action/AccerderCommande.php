<?php

namespace pizzashop\gateway\action;

use pizzashop\gateway\action\AbstractAction;


class AccerderCommande extends AbstractAction
{

    public function __invoke(\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Message\ResponseInterface $response, array $args): \Psr\Http\Message\ResponseInterface
    {
        return $this->requeteGuzzle('GET', $this->container->get('link_shop').'/commandes/' . $args['id'], $request, $response);
    }

}