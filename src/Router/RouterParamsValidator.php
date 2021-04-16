<?php

namespace Lavi\Router;

class RouterParamsValidator implements IRouterParamsValidator
{
    private const CONTROLLER = 'controller';
    private const ACTION = 'action';

    public array $errors;

    private array $neededParams = [self::CONTROLLER, self::ACTION];

    public function validate(array $params): bool
    {
        if (empty($params)) {
            return false;
        }

        foreach ($this->neededParams as $neededParam) {
            if (!array_key_exists($neededParam, $params)) {
                $this->errors[$neededParam] = 'Empty';
                continue;
            }
        }

        return true;
    }
}