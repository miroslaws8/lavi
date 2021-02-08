# Lavi Framework

### Install

1. Clone the project;
2. Run composer install;
3. Write the configuration file in `public/config.php`
4. It's all !

### Config


```php
    $config = new Lavi\Config\Config();

    // Load to config file
    $config->load('path_to_file_config.php');

    // Get all config params
    $config->all();

    // Get param by key
    $config->get('key');
```

### Routes

You can specify the namespace explicitly in the controller name.

``` php
$router->add('',
    ['controller' => 'MyNamespace\HomeController', 'action' => 'index']
);
```

It is also possible to declare it.

``` php
$router->add('', [
    'namespace'  => 'MyNamespace',
    'controller' => 'HomeController',
    'action'     => 'index'
]);
```

### Controllers

The controllers are located in the `src/controllers` folder,
but you can store them wherever convenient for you.

**Events Controller** (in progress)

There are 2 events that you can subscribe to in the controller.

1. before();
2. after();

Methods that must be subscribed to these events must begin with the prefix `do`.

### Tests
Tests run on the PHPUnit library.

Tests are in the tests folder.

Run tests:

`composer test`
