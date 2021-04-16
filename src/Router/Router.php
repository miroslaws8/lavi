<?php

namespace Lavi\Router;

use Exception;
use Lavi\Exceptions\RouteException;

class Router implements IRouter
{
    public const METHOD_GET = 'GET';
    public const METHOD_POST= 'POST';

    protected array $routes = [];
    protected array $availableMethods = [self::METHOD_GET, self::METHOD_POST];

    protected array $params = [];

    protected IRouterParamsValidator $paramsValidator;

    /**
     * @throws RouteException
     */
    public function __construct()
    {
        if (!$this->isAvailableHttpMethod()) {
            throw new RouteException('Unsupported cli!');
        }

        $this->paramsValidator = new RouterParamsValidator();
    }

    /**
     * @throws RouteException
     */
    public function get(string $route, array $params = []): void
    {
        $this->add(static::METHOD_GET, $route, $params);
    }

    /**
     * @throws RouteException
     */
    public function post(string $route, array $params = []): void
    {
        $this->add(static::METHOD_POST, $route, $params);
    }

    /**
     * @throws RouteException
     */
    protected function add(string $method, string $route, array $params = []): void
    {
        if (!$this->isAvailableMethod($method)) {
            throw new RouteException('Forbidden http method.');
        }

        $route = preg_replace('/\//', '\\/', $route);
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);
        $route = '/^'.$route.'$/i';

        $this->routes[$method][$route] = $params;
    }

    public function getHttpMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    private function isAvailableHttpMethod(): bool
    {
        return in_array($this->getHttpMethod(), $this->availableMethods);
    }

    private function isAvailableMethod(string $method): bool
    {
        return in_array($method, $this->availableMethods);
    }

    public function getRoutesByMethod(string $method): array
    {
        if (!array_key_exists($method, $this->routes)) {
            return [];
        }

        return $this->routes[$method];
    }

    /**
     * @throws RouteException
     */
    public function match(string $url): bool
    {
        $routes = $this->getRoutesByMethod($this->getHttpMethod());

        if (sizeof($routes) === 0) {
            return false;
        }

        foreach ($routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }

                if (!$this->paramsValidator->validate($params)) {
                    throw new RouteException($this->paramsValidator->errors);
                }

                $this->params = $params;

                return true;
            }
        }

        return false;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @throws Exception
     */
    public function dispatch(string $url): array
    {
        $url = $this->removeQueryStringVariables($url);

        if (!$this->match($url)) {
            throw new RouteException('No route matched.', 404);
        }

        $controller = $this->params['Controller'];
        $controller = $this->convertToStudlyCaps($controller);
        $controller = $this->getNamespace().$controller.'Controller';

        $action = $this->params['action'];
        $action = $this->convertToCamelCase($action);

        return [$controller, $action];
    }

    protected function convertToStudlyCaps($string): string
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    protected function convertToCamelCase($string): string
    {
        return lcfirst($this->convertToStudlyCaps($string));
    }

    protected function removeQueryStringVariables($url): string
    {
        if ($url != '') {
            $parts = explode('&', $url, 2);

            if (strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }

        return $url;
    }

    protected function getNamespace(): string
    {
        if (array_key_exists('namespace', $this->params)) {
            return $this->params['namespace'] . '\\';
        }

        return 'controllers\\';
    }
}