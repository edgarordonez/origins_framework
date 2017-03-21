<?php

namespace App\Models;

use Core\ORM;

class User extends ORM
{
    public $id;
    public $name;
    public $email;
    public $password;
    protected static $table = 'Users';

    public function __construct($object = null)
    {
        if($object != null) {
            foreach ($object as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    public function getAll()
    {
        return $this->all();
    }

    public function getUser($id)
    {
        return $this->find($id);
    }

    public function valid($user)
    {
        $userExist = $this->exits($user->email);

        if(!$userExist) {
            return false;
        }

        return password_verify($user->password, $userExist[0]->password);
    }

    public function exits($email)
    {
        return $this->where('email', $email) != null;
    }

    public function register()
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        $this->save();
    }
}