<?php

namespace pizzashop\auth\api\app\action\get;

use Exception;
use pizzashop\auth\api\app\action\AbstractAction;
use pizzashop\auth\api\domain\provider\AuthenticationProvider;
use pizzashop\auth\api\domain\service\AuthenticationService;
use pizzashop\auth\api\domain\service\utils\JWTManager;
use pizzashop\auth\api\Exception\ExpiredTokenException;
use pizzashop\auth\api\Exception\InvalidTokenException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ValidateAction extends AbstractAction
{

    /**
     * @throws Exception
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $authHeader = $request->getHeaderLine('Authorization');
        $token = substr($authHeader, 7);

        $jwtManager = $this->container->get('jwtmanager');
        $authProvider = new AuthenticationProvider();
        $authService = new AuthenticationService($jwtManager, $authProvider);

        try {
            $data = $authService->validate($token);
            $status = 200;
        } catch (InvalidTokenException|ExpiredTokenException|Exception $e) {
            $data = $this->exception($e);
            $status = $e->getCode();
        }

        $data = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $data = str_replace('\/', '/', $data);
        $response->getBody()->write($data);
        return $response->withHeader('Content-Type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withStatus($status);
    }
}