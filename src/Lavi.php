<?php

namespace Lavi;

use Lavi\Exceptions\LaviException;
use Lavi\Exceptions\RouteException;
use Lavi\Middleware\Dispatcher;
use Lavi\Request\IRequest;
use Lavi\Request\SymfonyRequest;
use Lavi\Response\ApiResponse;
use Lavi\Router\IRouter;
use Lavi\Router\Route;
use Psr\Container\ContainerInterface;

class Lavi
{
    public IRequest $request;
    private ?ContainerInterface $container;

    public function __construct(ContainerInterface $container = null)
    {
        $this->container = $container;

        $request = SymfonyRequest::createFromGlobals();

        $this->request = $request;
        $this->container->set(IRequest::class, $request);
        $this->container->set(ApiResponse::class, function () {
            return new ApiResponse();
        });
    }

    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    public function setRequest(IRequest $request)
    {
        $this->request = $request;
    }

    /**
     * @throws RouteException
     */
    public function run(IRouter $router)
    {
        $route = $router->dispatch($this->request->getPathInfo());

        if (!method_exists($route->getController(), $route->getMethod())) {
            throw new RouteException('Action not found!');
        }

        try {
            $default = function () use ($route) {
                $controllerInstance = $this->container->make($route->getController());
                return $this->container->call([$controllerInstance, $route->getMethod()], $route->getParams());
            };

            $dispatcher = $this->container->make(Dispatcher::class, [
                Route::ROUTE_MIDDLEWARES => $route->getMiddlewares()
            ]);

            $response = $dispatcher->dispatch($this->container->get(IRequest::class), $default);
        } catch (LaviException $exception) {
            $response = $exception->getMessage();
        }

        return $response;
    }
}