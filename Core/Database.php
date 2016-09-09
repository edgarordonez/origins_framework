<?php
namespace Core;

class Database
{
    private $connect;
    private static $instance;

    public function __construct()
    {
        $configDb = parse_ini_file(PROJECT_PATH."/Config/database.ini");
        $dsn = "mysql:host={$configDb['host']};dbname={$configDb['database']};charset=utf8";
        $user = $configDb['user'];
        $password = $configDb['password'];

        try {
            $this->connect = new \PDO($dsn, $user, $password, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING));
            self::$instance = $this->connect;
        } catch (\PDOException $e) {
            print "Error!: ".$e->getMessage();
            die();
        }
    }

    public function prepare($query)
    {
        return $this->connect->prepare($query);
    }

    public static function instance()
    {
        if (!isset(self::$instance))
        {
            $class = __CLASS__;
            self::$instance = new $class;
        }
        return self::$instance;
    }
}