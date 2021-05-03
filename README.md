# Lavi Framework

### Install

`composer require itsimiro/lavi`

DI Container is a required dependency.
Install any package that implements ContainerInterface.

### Routes

The framework router currently supports GET and POST requests.

You can specify the namespace explicitly in the controller name.

``` php
$router = new \Lavi\Router\Router();

$router->get('/', [
    'controller' => 'MyNamespace\HomeController',
    'action' => 'index'
]);
```

It is also possible to declare it.

``` php
$router->post('/users/', [
    'namespace'  => 'MyNamespace',
    'controller' => 'UserController',
    'action'     => 'add'
]);
```

### Middlewares

You can use middlewares for routes. Execution occurs one at a time.

``` php
$router->get('/me/', [
    'namespace' => 'App\\Controllers',
    'controller' => 'UserController',
    'action' => 'retrieve',
    'middlewares' => [\App\Middlewares\AuthMiddleware::class]
]);
```

### Request

It is possible to use different requests, by default we use Symfony Request.
If you want to use your own request class, then it must implement the `IRequest` interface.

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
