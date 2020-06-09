<?php

namespace Lavi\Router;

interface IRouter
{
    public function dispatch(string $uri): array;
}