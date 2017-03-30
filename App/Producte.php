<?php

namespace App;


use Core\Origins;

class Producte extends Origins
{
    protected static $table = 'Productes';
    protected static $foreignKeys = [
        [
            'name' => 'familia',
            'class' => Familia::class
        ]
    ];
    public $codi;
    public $nom;
    public $nom_curt;
    public $descripcio;
    public $PVP;
    public $familia;
}