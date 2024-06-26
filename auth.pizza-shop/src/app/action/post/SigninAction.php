<?php

namespace pizzashop\auth\api\app\action\post;

use Exception;
use pizzashop\auth\api\app\action\AbstractAction;
use pizzashop\auth\api\domain\provider\AuthenticationProvider;
use pizzashop\auth\api\domain\service\AuthenticationService;
use pizzashop\auth\api\domain\service\utils\JWTManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SigninAction extends AbstractAction
{

    /**
     * @throws Exception
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $authHeader = $request->getHeaderLine('Authorization');
        list($email, $password) = explode(':', base64_decode(substr($authHeader, 6)));

        $jwtManager = $this->container->get('jwtmanager');
        $authProvider = new AuthenticationProvider();

        $authService = new AuthenticationService($jwtManager, $authProvider);

        try {
            $data = $authService->signin($email, $password);
            $status = 200;
        } catch (Exception $e) {
            $data = $this->exception($e);
            $status = $e->getCode();
        }


        $data = $this->formatJSON($data);
        $response->getBody()->write($data);
        return $response->withHeader('Content-Type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withStatus($status);
    }
}