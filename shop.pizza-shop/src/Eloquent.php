<?php

namespace pizzashop\shop;

use Illuminate\Database\Capsule\Manager as DB;

class Eloquent {
    public static function init($filename): void {
        $db = new DB;
        $db->addConnection(parse_ini_file($filename));
        $db->setAsGlobal();
        $db->bootEloquent();
    }
}