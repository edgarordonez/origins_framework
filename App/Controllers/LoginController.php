<?php
namespace App\Controllers;

use App\Models\User;
use Core\Controller;

class LoginController extends Controller
{
    public function index()
    {
        $this->display("login.html.twig", []);
    }

    public function auth()
    {
        $user = new User((object)$_POST);

        if($user->valid($user)) {
            $this->userSession($user);
            $this->redirect('/users');
        } else {
            $this->redirect('/login');
        }
    }

    public function register()
    {
        $user = new User((object)$_POST);

        if(!$user->exits($user->email)) {
            $this->userSession($user);
            $user->register();
            $this->redirect('/users');
        } else {
            $this->redirect('/login');
        }
    }

    private function userSession($user)
    {
        $_SESSION['email'] = $user->email;
    }
}