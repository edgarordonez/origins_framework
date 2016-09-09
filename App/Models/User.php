<?php
namespace App\Models;

use Core\ORM;

class User extends ORM
{
    public $id;
    public $name;
    public $age;
    public $city;
    protected static $table = 'users';

    public function __construct()
    {
        parent::__construct();
    }

    public function getAll()
    {
        User::getAll();
    }

    public function getUser($id)
    {
        return User::getUser($id);
    }

    public function save()
    {
        return User::save($this);
    }
}