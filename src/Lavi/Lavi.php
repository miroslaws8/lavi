<?php

namespace Lavi;


use Lavi\Response\Response;
use Lavi\Router\Router;
use Lavi\Config\Config;

class Lavi
{
    public $router;

    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->router = $this->factoryRouter();
    }

    public function factoryRouter()
    {
        return new Router;
    }

    public function run()
    {
        $handler = $this->router->dispatch($_SERVER['QUERY_STRING']);

        if (!is_callable($handler)) {
            throw new \Exception('Action not found!');
        }

        try {
            $response = call_user_func($handler);
        } catch (\Exception $exception) {
            $response = $exception->getMessage();
        }

        Response::send($response);
    }
}