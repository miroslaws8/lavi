<?php

namespace Lavi\Request;

use Symfony\Component\HttpFoundation\Request;

class SymfonyRequestAdapter extends Request implements IRequest
{
    public function all()
    {
        return $this->all();
    }

    public function set(string $key, mixed $value)
    {
        return $this->set($key, $value);
    }

    public function has(string $key): bool
    {
        return $this->has($key);
    }
}