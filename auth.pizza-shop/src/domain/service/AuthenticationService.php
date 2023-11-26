<?php

namespace pizzashop\auth\api\domain\service;

use Exception;
use MongoDB\Driver\Exception\AuthenticationException;
use pizzashop\auth\api\domain\dto\UserDTO;
use pizzashop\auth\api\domain\entities\User;
use pizzashop\auth\api\domain\provider\AuthenticationProvider;
use pizzashop\auth\api\domain\service\utils\JWTManager;
use pizzashop\auth\api\Exception\ExpiredTokenException;
use pizzashop\auth\api\Exception\InvalidTokenException;
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

    private function generateToken(string $email) : array
    {
        $userDTO = $this->authenticationProvider->getUserProfile($email);
        if ($userDTO) {
            $tokenData = [
                "username" => $userDTO->username,
                "email" => $userDTO->email
            ];
            $accessToken = $this->jwtManager->createToken($email, $tokenData);
            $refreshToken = Uuid::uuid4();
            $user = User::where('email', $email)->first();
            $user->refresh_token = $refreshToken;
            $user->refresh_token_expiration_date = date("Y-m-d H:i:s", strtotime("+1 month"));
            $bool = $user->update();
            if ($bool)
                return ['access_token' => $accessToken, 'refresh_token' => $refreshToken];
            else throw new Exception("Update failed", 500);
        }
        throw new Exception("User not found", 404);
    }
    /**
     * @throws Exception
     */
    public function signin(string $email, string $password): array
    {
        if($this->authenticationProvider->authenticateWithCredentials($email, $password)){
            return $this->generateToken($email);
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
        throw new InvalidTokenException("Invalid token", 401);
    }

    /**
     * @throws Exception
     */
    public function refresh(string $refreshToken): array
    {
            $user = $this->authenticationProvider->authenticateWithRefreshToken($refreshToken);
            if (isset($user)) {
                if (date("Y-m-d H:i:s") < $user->refresh_token_expiration_date)
                    return $this->generateToken($user->email);
                else {
                    throw new ExpiredTokenException("Refresh token expired", 401);
                }
            } else throw new InvalidTokenException("Invalid refresh token", 401);

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