<?php

namespace Lavi\Controller;

use Lavi\Request\IRequest;

abstract class Controller
{
    protected array $params = [];
    protected IRequest $request;

    public function __construct(IRequest $request)
    {
        $this->request = $request;
    }

    protected function before(): void
    {

    }

    protected function after(): void
    {

    }
}