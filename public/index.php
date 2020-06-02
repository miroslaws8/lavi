<?php

require_once __DIR__.'/../vendor/autoload.php';

$config = new Lavi\Config\Config();
$app    = new Lavi\Lavi($config);

$app->router->add('test', [
    'Controller' => 'Home', 'action' => 'index'
]);

try {
    $app->run();
} catch (Exception $exception) {
    echo $exception->getMessage();
}
