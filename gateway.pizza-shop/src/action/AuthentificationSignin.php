<?php

namespace pizzashop\gateway\action;

use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AuthentificationSignin extends AbstractAction
{

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        return $this->requeteGuzzle('POST', $this->container->get('link_auth').'/signin', $request, $response);
    }
}