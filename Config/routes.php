<?php

return [
    ['GET', '/', 'HomeController::index'],

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