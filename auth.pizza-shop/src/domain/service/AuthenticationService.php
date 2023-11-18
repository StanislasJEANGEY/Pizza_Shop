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

    // signin : reçoit des credentials et retourne un couple (access_token, refresh_token)

    /**
     * @throws Exception
     */
    public function signin(string $email, string $password): array
    {
        $user = $this->authenticationProvider->findUserByEmail($email);
        if ($user && password_verify($password, $user->getPassword())) {
            // /!\ Les 2 méthodes n'existe pas jsp s'il faut les créer ou si ma méthode signin n'est pas bonne
            $access_token = $this->jwtManager->generateAccessToken($user);
            $refresh_token = $this->jwtManager->generateRefreshToken($user);
            return [
                'access_token' => $access_token,
                'refresh_token' => $refresh_token
            ];
        } else {
            throw new Exception("Invalid credentials", 401);
        }
    }


}