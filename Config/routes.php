<?php

return [
    ['GET', '/', 'HomeController::index'],

    ['GET', '/producte', 'ProductesController::index'],
    ['GET', '/producte/add', 'ProductesController::add'],
    ['GET', '/producte/edit/.+', 'ProductesController::update'],
    ['POST', '/producte/save', 'ProductesController::save'],
    ['GET', '/producte/delete/.+', 'ProductesController::delete'],

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