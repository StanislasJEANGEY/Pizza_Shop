<?php

namespace pizzashop\auth\api\domain\service\utils;

use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTManager
{
    private $secret;
    private $tokenLifetime;

    public function __construct($secret, $tokenLifetime)
    {
        $this->secret = $secret;
        $this->tokenLifetime = $tokenLifetime;
    }

    public function createToken($issuer, $userProfile): string
    {
        $issuedAt = time();
        $expiration = $issuedAt + $this->tokenLifetime;

        $payload = array(
            "iss" => $issuer,
            "iat" => $issuedAt,
            "exp" => $expiration,
            "upr" => $userProfile
        );

        $token = JWT::encode($payload, $this->secret, 'HS256');

        return $token;
    }

    /**
     * @throws \Exception
     */
    public function validateToken($token)
    {
        try {
            $payload = JWT::decode($token, new Key($this->secret, 'HS256'));
            return $payload;
        } catch (\Firebase\JWT\ExpiredException $e) {
            // Token expiré
            throw new ExpiredException($e->getMessage());
        } catch (\Exception $e) {
            // Token invalide
            throw new \Exception($e->getMessage());
        }
    }
}