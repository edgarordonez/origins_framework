<?php

namespace Core;

class Database
{
    private $connect;
    private static $instance;

    public function __construct()
    {
        $configDb = parse_ini_file(PROJECT_PATH . '/Config/database.ini');
        $host = $configDb['host'];
        $username = $configDb['user'];
        $passwd = $configDb['password'];
        $dbname = $configDb['database'];

        $this->connect = new \mysqli($host, $username, $passwd, $dbname);

        if ($this->connect->connect_errno) {
            print 'Error!: ' . $mysqli->connect_errno;
            die();
        }
        $this->connect->set_charset("utf8");

        self::$instance = $this->connect;
    }

    public function prepare($query)
    {
        return $this->connect->prepare($query);
    }

    public static function lastInsertId()
    {
        return self::$instance->insert_id;
    }

    public static function instance()
    {
        if (!isset(self::$instance)) {
            $class = __CLASS__;
            self::$instance = new $class;
        }

        return self::$instance;
    }
}