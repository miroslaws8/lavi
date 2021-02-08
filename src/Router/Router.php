<?php

namespace Lavi\Router;

class Router implements IRouter
{
    protected array $routes = [];
    protected array $params = [];

    public function add(string $route, array $params = []): void
    {
        $route = preg_replace('/\//', '\\/', $route);
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);
        $route = '/^'.trim($route, '/').'$/i';

        $this->routes[$route] = $params;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function match(string $url): bool
    {
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
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

    public function dispatch(string $url): array
    {
        $url = $this->removeQueryStringVariables($url);

        if (!$this->match($url)) {
            throw new \Exception('No route matched.', 404);
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