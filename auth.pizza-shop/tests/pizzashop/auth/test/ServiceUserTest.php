<?php

namespace pizzashop\auth\test;

require_once __DIR__ . '/../../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;
use PHPUnit\Framework\TestCase;
use pizzashop\auth\api\domain\entities\User;
use pizzashop\auth\api\domain\service\UserService;

class ServiceUserTest extends TestCase
{




    private static $user_email;
    private static $serviceUser;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        $dbauth = __DIR__ . '/../../config/auth.db.ini';
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


    }



}