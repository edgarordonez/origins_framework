<?php
namespace App\Controllers;

use App\Controllers\Error\Error_404;
use App\Models\Users;
use Core\Controller;

class Login extends Controller
{

    public function index()
    {
        $this->display("login.html.twig", []);
    }

    public function auth()
    {
        if(!isset($_POST['email']))
        {
            $error = new Error_404;
            call_user_func_array([$error, "index"], array());
            exit;
        }
        $user = new Users((object)$_POST);

        if($user->valid($user)) {
            $this->redirect('/users');
        } else {
            $this->redirect('/login');
        }
    }

    public function register()
    {
        if(!isset($_POST['email'])) {
            $error = new Error_404;
            call_user_func_array([$error, "index"], array());
            exit;
        }

        $user = new Users((object)$_POST);
        if(!$user->exits($user->email)) {
            $user->register();
            $this->redirect('/users');
        } else {
            $this->redirect('/login');
        }
    }
}