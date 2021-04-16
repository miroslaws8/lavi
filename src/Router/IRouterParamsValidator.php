<?php

namespace Lavi\Router;

interface IRouterParamsValidator
{
    public function validate(array $params): bool;
}