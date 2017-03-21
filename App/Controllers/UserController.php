<?php
namespace App\Controllers;

use Core\Controller;
use App\Models\User;

class UserController extends Controller
{
    private $user;

    public function __construct()
    {
        if(!isset($_SESSION['email'])) {
            echo 'Acces denied';
            exit;
        }

        $this->user = new User();
    }

    public function getAll()
    {
        $users = $this->user->getAll();
        echo '<pre>';
        echo json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        echo '</pre>';
    }

   public function getUser($id)
    {
        $users = $this->user->getUser($id);

        echo '<pre>';
        echo json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        echo '</pre>';
    }
}