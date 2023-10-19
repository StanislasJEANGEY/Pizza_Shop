<?php

namespace pizzashop\auth\test;

require_once __DIR__ . '/../../vendor/autoload.php';

use Illuminate\Support\Facades\DB;
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
        $dbcom = __DIR__ . '/../../config/commande.db.ini';
        $dbcat = __DIR__ . '/../../config/catalog.db.ini';
        $db = new DB();
        $db->addConnection(parse_ini_file($dbcom), 'commande');
        $db->addConnection(parse_ini_file($dbcat), 'catalog');
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