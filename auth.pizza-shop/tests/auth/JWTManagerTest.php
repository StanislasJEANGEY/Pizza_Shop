<?php

namespace pizzashop\auth\test\auth;

use Firebase\JWT\ExpiredException;
use PHPUnit\Framework\TestCase;
use pizzashop\auth\api\domain\service\utils\JWTManager;

class JWTManagerTest extends TestCase
{
    private JWTManager $jwtManager;

    protected function setUp(): void
    {
        // Initialisez la classe JWTManager avec le secret et la durée de vie de test
        $this->jwtManager = new JWTManager('your-secret-key', 2);
    }

    public function testCreateAndValidateToken()
    {
        // Données de test
        $issuer = 'your-issuer';
        $userProfile = ['username' => 'testuser', 'mail' => 'test@example.com'];

        // Créez un jeton
        $token = $this->jwtManager->createToken($issuer, $userProfile);

        // Assurez-vous que le jeton n'est pas vide
        $this->assertNotEmpty($token);

        // Validez le jeton
        $decodedToken = $this->jwtManager->validateToken($token);

        // Assurez-vous que le jeton décodé n'est pas nul
        $this->assertNotNull($decodedToken);

        // Assurez-vous que le jeton a les informations attendues
        $this->assertEquals($issuer, $decodedToken->iss);

        // Assurez-vous que le jeton a été émis il y a moins de 5 secondes
        $this->assertLessThanOrEqual(5, time() - $decodedToken->iat);

        // Assurez-vous que le jeton expire dans moins de 3600 secondes
        $this->assertLessThanOrEqual(3600, $decodedToken->exp - time());

        // Assurez-vous que le jeton a les informations attendues
        $this->assertEquals($userProfile['username'], $decodedToken->upr->username);
        $this->assertEquals($userProfile['mail'], $decodedToken->upr->mail);
    }



    public function testExpiredToken()
    {
        // Données de test
        $issuer = 'your-issuer';
        $userProfile = ['username' => 'testuser', 'mail' => 'test@example.com'];

        // Créez un jeton avec une durée de vie très courte
        $token = $this->jwtManager->createToken($issuer, $userProfile);

        // Attendez quelques secondes pour que le jeton expire
        sleep(2);

        try {
            // Validez le jeton expiré et attendez une exception
            $decodedToken = $this->jwtManager->validateToken($token);
        } catch (ExpiredException $e) {
            // Assurez-vous que l'exception est levée en raison de l'expiration
            $this->assertInstanceOf(ExpiredException::class, $e);
            $this->assertEquals('Expired token', $e->getMessage());
            return;
        }

        // Si aucune exception n'a été levée, le test échoue
        $this->fail('Expected an ExpiredException, but no exception was thrown.');
    }
}
