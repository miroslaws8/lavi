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

### DataBase Repository (in progress)

Methods:

You can call model methods both static and through `$this`.

1. `getAll(?array $where, ?string $orderBy)`
2. `getOne(?array $where)`
3. `insert(array $values)`
4. `update(array $values, int $id)`
5. `delete(int $id)`
6. `doPagination(int $offset, int $limit, ?array $where, ?string $orderBy)`

### Utils

**Paginator** (in progress)

This tool allows you to display pagination.

``` php
$paginator->render(int $current, int $total);
```

**Uploader**

Methods

1. `uploadPicture($file, $storagePath, $id)`

### Tests
Tests run on the PHPUnit library.

Tests are in the tests folder.

Run tests:

`composer test`
