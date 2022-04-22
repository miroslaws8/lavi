<?php

namespace Lavi;

use Lavi\Exceptions\LaviException;
use Lavi\Request\IRequest;
use Lavi\Request\SymfonyRequestAdapter;
use Lavi\Config\Config;
use Lavi\Router\IRouter;

class Lavi
{
    public IRequest $request;
    private Config $config;

    public function __construct(Config $config)
    {
        $this->config  = $config;
        $this->request = new SymfonyRequestAdapter();
    }

    public function setRequest(IRequest $request)
    {
        $this->request = $request;
    }

    /**
     * @throws LaviException
     */
    public function run(IRouter $router)
    {
        $handler = $router->dispatch($this->request->getUri());

        if (!is_callable($handler)) {
            throw new LaviException('Action not found!');
        }

        try {
            $response = call_user_func($handler);
        } catch (LaviException $exception) {
            $response = $exception->getMessage();
        }

        return $response;
    }
}