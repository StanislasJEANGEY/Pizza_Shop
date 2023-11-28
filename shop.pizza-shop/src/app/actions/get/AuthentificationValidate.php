<?php

namespace pizzashop\shop\app\actions\get;

use pizzashop\shop\app\actions\AbstractAction;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AuthentificationValidate extends AbstractAction
{

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        // récupération du token en provenance du client
        $token = $request->getHeader('Authorization');
        // renvoie vers l'api authentification avec le token avec guzzle
        if (isset($token[0])) {
            // renvoie la réponse de l'api authentification
            return $this->container->get('guzzle')->request('GET', $this->container->get('link_auth') . 'validate', [
                'headers' => [
                    'Authorization' => $token[0]
                ]
            ]);
        } else {
            // renvoie une erreur si le token n'est pas présent
            return $response->withStatus(401);
        }
    }
}