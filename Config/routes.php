<?php

return [
    ['GET', '/', 'HomeController::index'],
    ['GET', '/shop', 'ShopController::index'],

    ['GET', '/producte', 'ProductesController::index'],
    ['GET', '/producte/add', 'ProductesController::add'],
    ['POST', '/producte/save', 'ProductesController::save'],
    ['GET', '/producte/edit/.+', 'ProductesController::update'],
    ['GET', '/producte/remove/.+', 'ProductesController::remove'],

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication.
    |
    */
    ['GET', '/login', 'Auth\\AuthController::index'],
    ['POST', '/login/auth', 'Auth\\LoginController::auth'],
    ['POST', '/login/register', 'Auth\\RegisterController::register'],
    ['GET', '/logout', 'Auth\\LogoutController::logout']
];