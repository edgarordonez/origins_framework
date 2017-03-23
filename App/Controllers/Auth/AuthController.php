<?php

namespace App\Controllers\Auth;

use Core\Controller;

class AuthController extends Controller
{
    protected $redirectTo = '/';
    protected $user;

    public function index()
    {
        if (!empty($_SESSION['user'])) {
            $this->redirect($this->redirectTo);
        }

        $this->display("login.html.twig", []);
    }

    protected function valid()
    {
        $result = $this->exits();

        if (!$result) {
            return false;
        }

        return password_verify($this->user->password, $result[0]->password);
    }

    protected function exits()
    {
        return $this->user->where('email', $this->user->email);
    }

    protected function create()
    {
        $this->user->password = password_hash($this->user->password, PASSWORD_DEFAULT);
        $this->user->save();
    }

    protected function logged()
    {
        $this->user = (object)$this->exits();
        $_SESSION['user'] = $this->user;
    }
}