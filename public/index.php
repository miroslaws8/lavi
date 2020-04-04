<?php

require_once '../vendor/autoload.php';

define('APP', __DIR__.DIRECTORY_SEPARATOR);
define("PUBLIC_ROOT", __DIR__.DIRECTORY_SEPARATOR);

\bundle\Session::init();

$router = new bundle\Router();

$router->add('',
    ['controller' => 'HomeController', 'action' => 'index']
);

$router->add('tasks/add',
    ['controller' => 'TaskController', 'action' => 'add']
);

$router->add(
    'login',
    ['controller' => 'LoginController', 'action' => 'index']
);

$router->add(
    'logout',
    ['controller' => 'LoginController', 'action' => 'logout']
);

$router->add(
    'login/signin',
    ['controller' => 'LoginController', 'action' => 'signin']
);

$router->add(
    'admin',
    ['controller' => 'AdminController', 'action' => 'index']
);

$router->dispatch($_SERVER['QUERY_STRING']);