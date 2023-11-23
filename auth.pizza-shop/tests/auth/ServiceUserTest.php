<?php

namespace pizzashop\auth\test\auth;

require_once __DIR__ . '/../../vendor/autoload.php';

use Exception;
use Illuminate\Database\Capsule\Manager as DB;
use PHPUnit\Framework\TestCase;
use pizzashop\auth\api\domain\entities\User;
use pizzashop\auth\api\domain\provider\AuthenticationProvider;
use pizzashop\auth\api\domain\service\AuthenticationService;
use pizzashop\auth\api\domain\service\utils\JWTManager;

class ServiceUserTest extends TestCase
{
    private static $user_email = [];

    private static $authService;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        $dbauth = __DIR__ . '/../../config/auth.db.ini';
        $db = new DB();
        $db->addConnection(parse_ini_file($dbauth), 'authentification');
        $db->setAsGlobal();
        $db->bootEloquent();

        self::$authService = new AuthenticationService(
            new JWTManager('secret', 3600),
            new AuthenticationProvider()
        );
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
    public function testCreateUser()
    {
        $userDTO = AuthenticationProvider::createUser('Jane', 'jane.doe@mail.com', 'Jane');
        $this->assertNotNull($userDTO);
        $this->assertEquals('Jane', $userDTO->username);
        self::$user_email[] = 'jane.doe@mail.com';
    }

    public function testAuthenticateWithCredentials()
    {
        $userDTO = AuthenticationProvider::authenticateWithCredentials('john.doe@mail.com', 'John');
        $this->assertTrue($userDTO);
        $userDTO = AuthenticationProvider::authenticateWithCredentials('john.doe@mail.com', 'Jane');
        $this->assertFalse($userDTO);
    }

    public function testAuthenticateWithRefreshToken()
    {
        $userDTO = AuthenticationProvider::authenticateWithRefreshToken('refresh_token');
        $this->assertNotNull($userDTO);
        $this->assertEquals(['John', 'john.doe@mail.com'], $userDTO);
        $this->assertNull(AuthenticationProvider::authenticateWithRefreshToken('refresh_token2'));
    }

    public function testGetUserProfile()
    {
        $userDTO = AuthenticationProvider::getUserProfile('john.doe@mail.com');
        $this->assertEquals(['email' => 'john.doe@mail.com', 'password' => 'a8cfcd74832004951b4408cdb0a5dbcd8c7e52d43f7fe244bf720582e05241da', 'refresh_token' => 'refresh_token'], $userDTO);
        $this->assertNull(AuthenticationProvider::getUserProfile('Spiderman'));
    }

//    public function testTest()
//    {
//        AuthenticationProvider::createUser('Johnny', 'johnny@mail.com', 'Johnny');
//    }


    /**
     * @throws Exception
     */
    public function testSignin()
    {

        $userDTO = self::$authService->signin('john.doe@mail.com', 'Johnny');
        $this->assertNotNull($userDTO);
        $this->assertEquals('Johnny', $userDTO->username);
    }

    /**
     * @throws Exception
     */
    public function testValidate()
    {
        $userDTO = self::$authService->validate('access_token');
        $this->assertNotNull($userDTO);
        // Tester la validité du token
    }

    /**
     * @throws Exception
     */
    public function testRefresh()
    {
        $userDTO = self::$authService->refresh('refresh_token');
        $this->assertNotNull($userDTO);
        // Tester la création du accessToken et du nouveau refreshToken
    }


}