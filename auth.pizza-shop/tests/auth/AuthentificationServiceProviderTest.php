<?php

namespace pizzashop\auth\test\auth;

require_once __DIR__ . '/../../vendor/autoload.php';

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Database\Capsule\Manager as DB;
use PHPUnit\Framework\TestCase;
use pizzashop\auth\api\domain\entities\User;
use pizzashop\auth\api\domain\provider\AuthenticationProvider;
use pizzashop\auth\api\domain\service\AuthenticationService;
use pizzashop\auth\api\domain\service\utils\JWTManager;

class AuthentificationServiceProviderTest extends TestCase
{
    private static $user_email = [];

    private static $authService;

    private static $JWTManager;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        $dbauth = __DIR__ . '/../../config/auth.db.ini';
        $db = new DB();
        $db->addConnection(parse_ini_file($dbauth), 'authentification');
        $db->setAsGlobal();
        $db->bootEloquent();

        self::$authService = new AuthenticationService(
            new JWTManager('secret_key', 3600),
            new AuthenticationProvider()
        );

        self::$JWTManager = new JWTManager('secret_key', 3600);
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

        AuthenticationProvider::authenticateWithCredentials('AlphonseFleury@sfr.fr', 'test');
    }

    public function testAuthenticateWithRefreshToken()
    {
        $user = User::where('email', 'john.doe@mail.com')->first();
        $user->refresh_token = 'refresh_token';
        $user->save();
        $userDTO = AuthenticationProvider::authenticateWithRefreshToken('refresh_token');
        $this->assertNotNull($userDTO);
        $this->assertEquals('John', $userDTO->username);
        $this->assertEquals('john.doe@mail.com', $userDTO->email);
        $this->assertNull(AuthenticationProvider::authenticateWithRefreshToken('refresh_token2'));
    }

    public function testGetUserProfile()
    {
        $userDTO = AuthenticationProvider::getUserProfile('john.doe@mail.com');
        $this->assertNotNull($userDTO);
        $this->assertEquals('John', $userDTO->username);
        $this->assertEquals('john.doe@mail.com', $userDTO->email);
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
        $token = self::$authService->signin('john.doe@mail.com', 'John');
        $this->assertNotNull($token);
        $data = self::$JWTManager->validateToken($token['access_token'])->upr;
        $this->assertEquals('John', $data->username );
        $this->assertEquals('john.doe@mail.com', $data->email );
    }

    /**
     * @throws Exception
     */
    public function testValidate()
    {
        $token = self::$authService->signin('john.doe@mail.com', 'John');
        $user = self::$authService->validate($token['access_token'] );
        $this->assertNotNull($user);
        $this->assertEquals('John', $user->username);
        $this->assertEquals('john.doe@mail.com', $user->email);
    }

    /**
     * @throws Exception
     */
    public function testRefresh()
    {
        $token = self::$authService->signin('john.doe@mail.com', 'John');
        $newToken = self::$authService->refresh($token['refresh_token']);
        $user = self::$authService->validate($newToken['access_token'] );
        $this->assertNotNull($user);
        $this->assertEquals('John', $user->username);
        $this->assertEquals('john.doe@mail.com', $user->email);

    }


}