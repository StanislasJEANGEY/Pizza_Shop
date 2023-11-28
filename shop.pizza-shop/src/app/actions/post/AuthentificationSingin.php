<?php

namespace pizzashop\shop\app\actions\post;

use pizzashop\shop\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AuthentificationSingin extends AbstractAction
{

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        try {
            return $this->container->get('guzzle')->request('POST', $this->container->get('link_auth') . 'signin', [
                'headers' => [
                    'Authorization' => $request->getHeaderLine('Authorization')
                ]
            ]);
        } catch (\Exception $e) {
            $data = $this->exception($e);
            $data = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            $data = str_replace('\/', '/', $data);
            $response->getBody()->write($data);
            return $response->withHeader('Content-Type', 'application/json')
                ->withStatus($e->getCode());
        }
    }
}