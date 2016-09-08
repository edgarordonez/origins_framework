<?php

namespace Core;


class Database
{
    private $connect;
    private static $instance;

    public function __construct()
    {
        $configDb = parse_ini_file(PROJECT_PATH."/Config/database.ini");
        $user = $configDb['user'];
        $password = $configDb['password'];
        $dsn = "mysql:host = {$configDb['host']},dbname = {$configDb['database']}, charset = utf8";

        try {
            $this->connect = new \PDO($dsn, $user, $password, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING));
        } catch (\PDOException $e) {
            print "Error!: ".$e->getMessage();
            die();
        }
    }

    public static function instance()
    {
        if (!isset(self::$instance))
        {
            self::$instance = new Database();
        }
        return self::$instance;
    }
}