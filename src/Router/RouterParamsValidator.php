<?php

namespace Lavi\Router;

class RouterParamsValidator implements IRouterParamsValidator
{
    public const CONTROLLER = 'controller';
    public const ACTION = 'action';

    private array $errors = [];
    private array $neededParams = [self::CONTROLLER, self::ACTION];

    public function getError(): string
    {
        return implode(';', $this->errors);
    }

    public function validate(array $params): bool
    {
        foreach ($this->neededParams as $neededParam) {
            if (!array_key_exists($neededParam, $params)) {
                $this->errors[$neededParam] = "$neededParam: empty";
            }
        }

        if (!empty($this->errors)) {
            return false;
        }

        return true;
    }
}