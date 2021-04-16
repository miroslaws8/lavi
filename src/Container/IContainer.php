<?php

namespace Lavi\Container;

interface IContainer
{
    public function get(string $key);
}