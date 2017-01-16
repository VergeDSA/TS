<?php
/**
 * Created by PhpStorm.
 * User: vergedsa
 * Date: 10.12.16
 * Time: 16:18
 */

namespace Libs\Framework;

class Db
{
    private static $params = array();
    private static $db = false;

    public function __construct()
    {
        if (false === self::$db) {
            self::init();
        }
    }

    public static function init()
    {
        self::$params = include(APPLICATION_FOLDER . '/Config/db_settings.php');
        self::$db = new \PDO(
            'mysql:host=' . self::$params['HOST'] . ';dbname=' . self::$params['DBNAME'],
            self::$params['USER'],
            self::$params['PASS'],
            include(APPLICATION_FOLDER . '/Config/pdo_settings.php')
        );
    }

    public static function getDbConnection()
    {
        if (false !== self::$db) {
            return self::$db;
        } else {
            self::init();
            return self::$db;
        }
    }
}
