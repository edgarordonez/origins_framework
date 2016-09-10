<?php
namespace App\Models;

use Core\ORM;

class Users extends ORM
{
    protected static $table = 'users';
    public $id;
    public $name;
    public $age;
    public $city;

    public function __construct($object = null)
    {
        parent::__construct();

        if($object != null)
        {
            foreach ($object as $key => $value)
            {
                $this->$key = $value;
            }
        }
    }

    public function getAll()
    {
        return parent::all();
    }

    public function getUser($id)
    {
        return parent::find($id);
    }

    public function exits($name)
    {
        return parent::where('name', $name) != null;
    }

    public function save()
    {
        return parent::save($this);
    }
}