<?php

namespace Lavi;

use Symfony\Component\HttpFoundation\Request;
use Lavi\Config\Config;
use Lavi\Router\IRouter;

class Lavi
{
    public Request $request;
    private Config $config;

    public function __construct(Config $config)
    {
        $this->config  = $config;
        $this->request = new Request();
    }

    public function run(IRouter $router)
    {
        $handler = $router->dispatch($this->request->getUri());

        if (!is_callable($handler)) {
            throw new \Exception('Action not found!');
        }

        try {
            $response = call_user_func($handler);
        } catch (\Exception $exception) {
            $response = $exception->getMessage();
        }

        return $response;
    }
}