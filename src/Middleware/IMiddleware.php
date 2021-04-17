<?php

namespace Lavi\Middleware;

use Lavi\Request\IRequest;
use Psr\Http\Message\ResponseInterface;

interface IMiddleware
{
    public function process(IRequest $request, $handler): ResponseInterface;
}