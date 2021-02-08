<?php

require_once __DIR__ . '/../vendor/autoload.php';

$config = new Lavi\Config\Config();
$app    = new Lavi\Lavi($config);
$router = new Lavi\Router\Router();

$router->add('test', [
    'namespace' => 'controllers', 'Controller' => 'Home', 'action' => 'index'
]);

try {
    $app->run($router);
} catch (Exception $e) {

}
