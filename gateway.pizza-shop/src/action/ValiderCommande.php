<?php

namespace pizzashop\gateway\action;

use pizzashop\gateway\action\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ValiderCommande extends AbstractAction
{

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        //todo
    }
}