<?php

namespace App;

use Core\Origins;

class User extends Origins
{
    protected static $table = 'Users';
    public $name;
    public $email;
    public $password;

    public function __construct($object = null)
    {
        $this->initObjectFromPost($object);
    }
}