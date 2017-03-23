<?php

namespace App\Controllers\Auth;

use App\User;

class LoginController extends AuthController
{
    public function auth()
    {
        $this->user = new User((object)$_POST);

        if ($this->valid()) {
            $this->logged();
            $this->redirect($this->redirectTo);
        } else {
            $this->redirect('/login');
        }
    }
}