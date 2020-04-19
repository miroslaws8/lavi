<?php

require_once '../vendor/autoload.php';

define('APP', __DIR__.DIRECTORY_SEPARATOR);
define("PUBLIC_ROOT", __DIR__.DIRECTORY_SEPARATOR);

\bundle\Session::init();

$router = new bundle\Router();

$router->add('',
    ['controller' => 'HomeController', 'action' => 'index']
);

$router->add('logout',
    ['controller' => 'UserController', 'action' => 'logout']
);

$router->add('signup',
    ['controller' => 'UserController', 'action' => 'index']
);

$router->add('signup/action',
    ['controller' => 'UserController', 'action' => 'signup']
);

$router->add('signin',
    ['controller' => 'UserController', 'action' => 'displaySignin']
);

$router->add('signin/action',
    ['controller' => 'UserController', 'action' => 'signin']
);


/* Settings */

$router->add('settings',
    ['controller' => 'SettingsController', 'action' => 'index']
);

$router->add('settings/action',
    ['controller' => 'SettingsController', 'action' => 'addSettings']
);

$router->add('game',
    ['controller' => 'GameController', 'action' => 'index']
);


$router->dispatch($_SERVER['QUERY_STRING']);