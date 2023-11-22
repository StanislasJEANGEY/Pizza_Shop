<?php

namespace pizzashop\auth\api\app\action\get;

use Exception;
use pizzashop\auth\api\app\action\AbstractAction;
use pizzashop\auth\api\domain\provider\AuthenticationProvider;
use pizzashop\auth\api\domain\service\AuthenticationService;
use pizzashop\auth\api\domain\service\utils\JWTManager;
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

        $jwtManager = new JWTManager("secret", 3600);
        $authProvider = new AuthenticationProvider();
        $authService = new AuthenticationService($jwtManager, $authProvider);

        $userProfile = $authService->validate($token);

        if ($userProfile) {
            $response->getBody()->write(json_encode($userProfile));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        }

        return $response->withStatus(401);
    }
}