<?php

namespace App\Controllers\Auth;

class LogoutController extends AuthController
{
    public function logout()
    {
        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
        }

        $this->redirect('/login');
    }
}