<?php

namespace pizzashop\auth\api\app\action;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

abstract class AbstractAction {

    protected ContainerInterface $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public function exception(\Exception $e) : array
    {
        return [
            'message' => $e->getCode().' : '.$e->getMessage(),
            'exception' => [
                [
                    'type' => get_class($e),
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ]
            ]
        ];
    }
	abstract public function __invoke(Request $request, Response $response, array $args):Response;
}