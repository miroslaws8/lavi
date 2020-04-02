<?php

require_once 'autoload.php';

define('APP', __DIR__.DIRECTORY_SEPARATOR);
define("PUBLIC_ROOT", __DIR__.DIRECTORY_SEPARATOR);

\bundle\Session::init();

$router = new bundle\Router();

$router->add('', ['controller' => 'HomeController', 'action' => 'index']);
$router->add(
    'sessions',
    ['controller' => 'SessionsController', 'action' => 'index']
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

$router->add(
    'films/add',
    ['controller' => 'FilmsController', 'action' => 'add']
);

$router->add(
    'films/{id:\d+}',
    ['controller' => 'FilmsController', 'action' => 'display']
);

$router->add(
    'films/{id:\d+}/edit',
    ['controller' => 'FilmsController', 'action' => 'edit']
);

$router->add(
    'films/{id:\d+}/remove',
    ['controller' => 'FilmsController', 'action' => 'remove']
);

$router->add(
    'order/add',
    ['controller' => 'OrderController', 'action' => 'add']
);

$router->dispatch($_SERVER['QUERY_STRING']);