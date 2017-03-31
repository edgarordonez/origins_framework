<?php
/**
 * Created by PhpStorm.
 * User: jfreixa
 * Date: 3/30/17
 * Time: 7:47 PM
 */

namespace App\Controllers;


use App\Familia;
use App\Producte;
use Core\Controller;

class ProductesController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->userNeedAuth();
    }

    public function index()
    {
        $user = $this->getAuthUser();
        $productes = Producte::all();
        $families = Familia::all();
        $this->display("productes/index.html.twig", [
            "productes" => $productes,
            "user" => $user,
            "families" => $families
        ]);
    }

    public function add()
    {
        $user = $this->getAuthUser();
        $producte = new Producte();
        $families = Familia::all();
        $this->display("productes/producte.html.twig", [
            "producte" => $producte,
            "user" => $user,
            "families" => $families
        ]);
    }

    public function update($id)
    {
        $user = $this->getAuthUser();
        $producte = Producte::find($id);
        $families = Familia::all();
        $this->display("productes/producte.html.twig", [
            "producte" => $producte,
            "user" => $user,
            "families" => $families
        ]);
    }

    public function save() {
        $producte = new Producte($_POST);
        $producte->save();
        $this->redirect("/producte");
    }

    public function delete($id) {
        $producte = Producte::find($id);
        $producte->delete();
        $this->redirect("/producte");
    }
}