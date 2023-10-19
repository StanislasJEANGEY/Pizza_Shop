<?php

namespace pizzashop\auth\test;

require_once __DIR__ . '/../../vendor/autoload.php';

use Exception;
use Illuminate\Database\Capsule\Manager as DB;
use PHPUnit\Framework\TestCase;
use pizzashop\auth\api\domain\entities\User;
use pizzashop\auth\api\domain\provider\AuthenticationProvider;
use pizzashop\auth\api\domain\service\UserService;

class ServiceUserTest extends TestCase
{
    private static $user_email;
    private static $serviceUser;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        $dbauth = __DIR__ . '/../../../config/auth.db.ini';
        $db = new DB();
        $db->addConnection(parse_ini_file($dbauth), 'authentification');
        $db->setAsGlobal();
        $db->bootEloquent();

        self::$serviceUser = new UserService();
        self::fill();
    }

    public static function tearDownAfterClass(): void
    {
        self::cleanDB();
    }


    private static function cleanDB()
    {
        foreach (self::$user_email as $id) {
            User::find($id)->delete();
        }
    }

    private static function fill()
    {
        $user = new User();
        $user->username = 'John';
        $user->email = 'john.doe@mail.com';
        $user->password = 'John';
        $user->refresh_token = 'refresh_token';
    }

    /**
     * @throws Exception
     */
    public function testCreateUser() {
        AuthenticationProvider::createUser('John', 'john.doe@mail.com', 'John');
        $user = User::where('username', 'John')->first();
        $this->assertNotNull($user);
        $this->assertEquals('John', $user->username);
    }

    public function testAuthenticateWithCredentials() {
        $this->assertTrue(AuthenticationProvider::authenticateWithCredentials('John', 'John'));
        $this->assertFalse(AuthenticationProvider::authenticateWithCredentials('John', 'Jane'));
        $this->assertFalse(AuthenticationProvider::authenticateWithCredentials('Jane', 'John'));
    }

    public function testAuthenticateWithRefreshToken() {
        $this->assertNotNull(AuthenticationProvider::authenticateWithRefreshToken('refresh_token'));
        $this->assertEquals(['John', 'john.doe@mail.com'], AuthenticationProvider::authenticateWithRefreshToken('refresh_token'));
        $this->assertNull(AuthenticationProvider::authenticateWithRefreshToken('refresh_token2'));
    }

    public function testGetUserProfile() {
        $this->assertNotNull(AuthenticationProvider::getUserProfile('John'));
        $this->assertEquals(['username' => 'John', 'email' => 'john.doe@mail.com', 'refresh_token' => 'refresh_token'], AuthenticationProvider::getUserProfile('John'));
        $this->assertNull(AuthenticationProvider::getUserProfile('Jane'));
    }

    /**
     * @throws Exception
     */
    public function testHashPassword() {
        $this->assertEquals('John', AuthenticationProvider::hashPassword('John'));
        $this->assertNotEquals('Jane', AuthenticationProvider::hashPassword('John'));
    }

}