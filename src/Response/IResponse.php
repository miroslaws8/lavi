<?php

namespace Lavi\Response;

use Psr\Http\Message\ResponseInterface;

interface IResponse extends ResponseInterface
{
    public function send();
    public function setData();
}