<?php

namespace pizzashop\auth\api\domain\service;

use Exception;
use MongoDB\Driver\Exception\AuthenticationException;
use pizzashop\auth\api\domain\entities\User;
use pizzashop\auth\api\domain\provider\AuthenticationProvider;
use pizzashop\auth\api\domain\service\utils\JWTManager;
use Ramsey\Uuid\Uuid;
use function PHPUnit\Framework\isNull;

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
        if($this->authenticationProvider->authenticateWithCredentials($email, $password)){
            $userDTO = $this->authenticationProvider->getUserProfile($email);
            if ($userDTO) {
                $tokenData = [
                    "username" => $userDTO->username,
                    "email" => $userDTO->email
                ];
                $accessToken = $this->jwtManager->createToken($email, $tokenData);
                $refreshToken = Uuid::uuid4();
                $userDTO->refresh_token = $refreshToken;
                $userDTO->refresh_token_expiration_date = date("Y-m-d H:i:s", time() + 3600);
                if ($userDTO->toUser()->update())
                    return ['access_token' => $accessToken, 'refresh_token' => $refreshToken];
                else throw new Exception("Update failed", 500);
            }
        }
        throw new AuthenticationException("Authentication failed", 401);
    }

    /**
     * @throws Exception
     */
    public function validate(string $accessToken): \stdClass
    {
        $tokenData = $this->jwtManager->validateToken($accessToken);
        if (isset($tokenData->upr)) return $tokenData->upr;
        throw new Exception("Invalid token", 401);
    }

    /**
     * @throws Exception
     */
    public function refresh(string $refreshToken): array
    {
            $user = $this->authenticationProvider->authenticateWithRefreshToken($refreshToken);
            if (isNull($user)) throw new Exception("Invalid refresh token", 401);
            else {
                if ($user->refresh_token_expiration_date < date("Y-m-d H:i:s")) throw new Exception("Refresh token expired", 401);
                else {
                    return $this->signin($user->email, $user->password);
                }
            }
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