<?php

namespace pizzashop\auth\api\domain\service;

use Exception;
use pizzashop\auth\api\domain\provider\AuthenticationProvider;
use pizzashop\auth\api\domain\service\utils\JWTManager;

class AuthenticationService
{
    private JWTManager $jwtManager;
    private AuthenticationProvider $authenticationProvider;

    public function __construct(JWTManager $jwtManager, AuthenticationProvider $authenticationProvider)
    {
        $this->jwtManager = $jwtManager;
        $this->authenticationProvider = $authenticationProvider;
    }

    /**
     * @throws Exception
     */
    public function signin(string $email, string $password): array
    {
        $user = $this->authenticationProvider->authenticateWithCredentials($email, $password);
        if ($user) {
            $tokenData = [
                "email" => $user->email,
                "password" => $user->password
            ];
            $accessToken = $this->jwtManager->createToken("pizzashop", $tokenData);
            $refreshToken = $this->jwtManager->createToken("pizzashop", ["refresh_token" => $user -> refresh_token]);
            return [$accessToken, $refreshToken];
        }
        throw new Exception("Authentication failed", 401);
    }

    /**
     * @throws Exception
     */
    public function validate(string $accessToken): array
    {
        $tokenData = $this->jwtManager->validateToken($accessToken);
        if (isset($tokenData->upr)) {
            return $tokenData->upr;
        }
        throw new Exception("Invalid token", 401);
    }

    /**
     * @throws Exception
     */
    public function refresh(string $refreshToken): array
    {
        $tokenData = $this->jwtManager->validateToken($refreshToken);
        if (isset($tokenData->refresh_token)) {
            $user = $this->authenticationProvider->authenticateWithRefreshToken($tokenData->refresh_token);
            if ($user) {
                $tokenData = [
                    "username" => $user->username,
                    "email" => $user->email
                ];
                $accessToken = $this->jwtManager->createToken("pizzashop", $tokenData);
                $refreshToken = $this->jwtManager->createToken("pizzashop", ["refresh_token" => $user -> refresh_token]);
                return [$accessToken, $refreshToken];
            }
        }
        throw new Exception("Invalid token", 401);
    }

    public function signup(string $username, string $email, string $password) //: array
    {
        // TODO
    }

    public function activate(string $token) //: bool
    {
        // TODO
    }

}