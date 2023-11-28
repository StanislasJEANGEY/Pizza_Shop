<?php

namespace pizzashop\shop\app\actions\post;

use pizzashop\shop\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AuthentificationSingin extends AbstractAction
{

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        //récupération les credentials en basic auth
        $credentials = $request->getHeader('Authorization');
        //renvoie vers l'api authentification avec les credentials avec guzzle
        $response = $this->container->get('guzzle')->request('POST', $this->container->get('link_auth') . '/signin', [
            'headers' => [
                'Authorization' => $credentials
            ]
        ]);
        //renvoie la réponse de l'api authentification
        return $response;

    }
}