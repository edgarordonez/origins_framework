<?php
namespace App\Models;

use Core\ORM;

class Users extends ORM
{
    protected static $table = 'users';
    public $id;
    public $name;
    public $email;
    public $password;

    public function __construct($object = null)
    {
        parent::__construct();

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
        $userExist = $this->where('email', $user->email);

        if($userExist) {
            return password_verify($user->password, $userExist[0]->password);
        }
    }

    public function exits($email)
    {
        return $this->where('email', $email) != null;
    }

    public function register()
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return $this->save($this);
    }
}