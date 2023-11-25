<?php

namespace pizzashop\auth\api\domain\service\utils;

use Exception;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use stdClass;

class JWTManager
{
    private $secret;
    private $tokenLifetime;

    public function __construct($secret, $tokenLifetime)
    {
        $this->secret = $secret;
        $this->tokenLifetime = $tokenLifetime;
    }

    public function createToken($idsuer, $userProfil): string
    {
        $issuedAt = time();
        $expiration = $issuedAt + $this->tokenLifetime;

        $payload = array(
            "iss" => $idsuer,
            "iat" => $issuedAt,
            "exp" => $expiration,
            "upr" => $userProfil
        );

        return JWT::encode($payload, $this->secret, 'HS256');
    }

    /**
     * @throws Exception
     */
    public function validateToken($token): stdClass
    {
        try {
            return JWT::decode($token, new Key($this->secret, 'HS256'));
        } catch (ExpiredException $e) {
            // Token expiré
            throw new ExpiredException($e->getMessage());
        } catch (Exception $e) {
            // Token invalide
            throw new Exception($e->getMessage());
        }
    }
}