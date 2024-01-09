<?php

namespace pizzashop\gateway\action;

use GuzzleHttp\Exception\ClientException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

abstract class AbstractAction {

    protected ContainerInterface $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function requeteGuzzle(string $methode, string $url, Request $request, Response $response) : Response
    {
        try {
            return $this->container->get('guzzle')->request($methode, $url, [
                'headers' => [
                    'Authorization' => $request->getHeaderLine('Authorization')
                ],
                'json' => json_decode($request->getBody(), true)
            ]);
        }catch (ClientException $e ){
            $data = $e->getResponse()->getBody()->getContents();
            $status = $e->getResponse()->getStatusCode();

        }catch (\Exception $e) {
            $data = $this->exception($e);
            $data = $this->formatJSON($data);
            $status = $e->getCode();
        }

        $response->getBody()->write($data);
        return $response->withHeader('Content-Type', 'application/json')
            ->withStatus($status);
    }

    public function exception(\Exception $e) : array
    {
        return [
            'message' => $e->getCode() .$e->getMessage(),
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

    public function formatJSON($data) : string
    {
        $data = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $data = str_replace(['\/', '\\\\', '\n', '\"'], ['/', '\\', '', '"'], $data);
        return $data;
    }
	abstract public function __invoke(Request $request, Response $response, array $args):Response;
}