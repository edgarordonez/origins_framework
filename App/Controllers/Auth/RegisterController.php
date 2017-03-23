<?php

namespace App\Controllers\Auth;

use App\User;

class RegisterController extends AuthController
{
    public function register()
    {
        $this->user = new User((object)$_POST);

        if (!$this->exits()) {
            $this->create();
            $this->logged();
            $this->redirect($this->redirectTo);
        } else {
            $this->redirect('/login');
        }
    }
}