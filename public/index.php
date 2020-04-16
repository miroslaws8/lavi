<?php

require_once '../vendor/autoload.php';

define('APP', __DIR__.DIRECTORY_SEPARATOR);
define("PUBLIC_ROOT", __DIR__.DIRECTORY_SEPARATOR);

\bundle\Session::init();

$router = new bundle\Router();

$router->add('',
    ['controller' => 'HomeController', 'action' => 'index']
);

$router->add('signup',
    ['controller' => 'SignupController', 'action' => 'index']
);

$router->add('signup/action',
    ['controller' => 'SignupController', 'action' => 'signup']
);

$router->dispatch($_SERVER['QUERY_STRING']);