<?php

namespace pizzashop\auth\test\auth;

require_once __DIR__ . '/../../vendor/autoload.php';

use Exception;
use Illuminate\Database\Capsule\Manager as DB;
use PHPUnit\Framework\TestCase;
use pizzashop\auth\api\domain\entities\User;
use pizzashop\auth\api\domain\provider\AuthenticationProvider;

class ServiceUserTest extends TestCase
{
    private static $user_email = [];

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        $dbauth = __DIR__ . '/../../config/auth.db.ini';
        $db = new DB();
        $db->addConnection(parse_ini_file($dbauth), 'authentification');
        $db->setAsGlobal();
        $db->bootEloquent();

        self::fill();
    }

    public static function tearDownAfterClass(): void
    {
        self::cleanDB();
    }


    private static function cleanDB(): void
    {
        foreach (self::$user_email as $email) {
            User::find($email)->delete();
        }
    }

    private static function fill(): void
    {
        // Création d'un utilisateur
        $user = new User();
        $user->username = 'John';
        $user->email = 'john.doe@mail.com';
        $user->password = hash("sha256", 'John');
        $user->refresh_token = 'refresh_token';
        self::$user_email[] = $user->email;

        $user->save();
    }

    /**
     * @throws Exception
     */
    public function testCreateUser() {
        $userDTO = AuthenticationProvider::createUser('Jane', 'jane.doe@mail.com', 'Jane');
        $this->assertNotNull($userDTO);
        $this->assertEquals('Jane', $userDTO->username);
        self::$user_email[] = 'jane.doe@mail.com';
    }

    public function testAuthenticateWithCredentials() {
        $userDTO = AuthenticationProvider::authenticateWithCredentials('John', 'John');
        $this->assertTrue($userDTO);
        $userDTO = AuthenticationProvider::authenticateWithCredentials('John', 'Jane');
        $this->assertFalse($userDTO);
    }

    public function testAuthenticateWithRefreshToken() {
        $userDTO = AuthenticationProvider::authenticateWithRefreshToken('refresh_token');
        $this->assertNotNull($userDTO);
        $this->assertEquals(['John', 'john.doe@mail.com'], $userDTO);
        $this->assertNull(AuthenticationProvider::authenticateWithRefreshToken('refresh_token2'));
    }

    public function testGetUserProfile() {
        $userDTO = AuthenticationProvider::getUserProfile('John');
        $this->assertNotNull($userDTO);
        $this->assertEquals(['username' => 'John', 'email' => 'john.doe@mail.com', 'refresh_token' => 'refresh_token'], $userDTO);
        $this->assertNull(AuthenticationProvider::getUserProfile('Spiderman'));
    }


}