<?php

namespace App\Controllers\Auth;

use Core\Controller;

class AuthController extends Controller
{
    protected $redirectTo = '/';
    protected $user;

    public function index()
    {
        if ($this->getAuthUser() !== null) {
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

        return password_verify($this->user->password, $result->password);
    }

    protected function exits()
    {
        return $this->user->where('email', $this->user->email)[0];
    }

    protected function create()
    {
        $this->user->password = password_hash($this->user->password, PASSWORD_DEFAULT);
        $this->user->save();
    }

    protected function logged()
    {
        $this->user = $this->exits();
        $_SESSION['user'] = serialize($this->user);
    }
}