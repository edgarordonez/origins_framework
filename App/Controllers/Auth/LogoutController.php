<?php

namespace App\Controllers\Auth;

class LogoutController extends AuthController
{
    public function logout()
    {
        session_destroy();
        $this->redirect('/login');
    }
}