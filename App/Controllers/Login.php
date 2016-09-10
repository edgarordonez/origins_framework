<?php
namespace App\Controllers;

use App\Controllers\Errors\Error_404;
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
        if(!isset($_POST['name']))
        {
            $error = new Error_404;
            call_user_func_array([$error, "index"], array());
            exit;
        }
        $user = new Users((object)$_POST);
        $user->save();
    }

    public function register()
    {
        if(!isset($_POST['name']))
        {
            $error = new Error_404;
            call_user_func_array([$error, "index"], array());
            exit;
        }
        $user = new Users((object)$_POST);
        if(!$user->exits($user->name))
        {
            $user->save();
            $this->redirect('/users');
        } else {
            echo "User exists!";
        }
    }
}