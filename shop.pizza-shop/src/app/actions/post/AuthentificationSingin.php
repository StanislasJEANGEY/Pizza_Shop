<?php

namespace pizzashop\shop\app\actions\post;

use pizzashop\shop\app\actions\AbstractAction;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AuthentificationSingin extends AbstractAction
{

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        //récupération les credentials en basic auth
        $credentials = $request->getHeader('Authorization');
        //renvoie vers l'api authentification avec les credentials avec guzzle
        if (isset($credentials[0])) {
            //renvoie la réponse de l'api authentification
            return $this->container->get('guzzle')->request('POST', $this->container->get('link_auth') . 'singin', [
                'headers' => [
                    'Authorization' => $credentials[0]
                ]
            ]);
        } else {
            //renvoie une erreur si les credentials ne sont pas présents
            return $response->withStatus(401);
        }

    }
}