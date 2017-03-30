<?php

namespace App;


use Core\Origins;

class Stock extends Origins
{
    protected static $table = 'Stocks';
    protected static $foreignKeys = [
        [
            'name' => 'botiga',
            'class' => Botiga::class
        ],
        [
            'name' => 'producte',
            'class' => Producte::class
        ]
    ];
    public $producte;
    public $botiga;
    public $unitats;
}