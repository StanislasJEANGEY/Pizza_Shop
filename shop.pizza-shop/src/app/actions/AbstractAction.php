<?php

namespace pizzashop\shop\app\actions;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

abstract class AbstractAction {
    protected ContainerInterface $conteneur;

    public function __construct(ContainerInterface $c) {
        $this->conteneur = $c;
    }
	abstract public function __invoke(Request $request, Response $response, array $args):Response;
}