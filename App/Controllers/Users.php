<?php
namespace App\Controllers;

use Core\Controller;

class Users extends Controller
{
    private $user;

    public function __construct()
    {
        if(!isset($_SESSION['email'])) {
            echo 'Acces denied';
            exit;
        } //TODO: Middleware session.

        $this->user = new \App\Models\Users();
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
        assert($id != null);

        $users = $this->user->getUser($id);
        echo '<pre>';
        echo json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        echo '</pre>';
    }
}