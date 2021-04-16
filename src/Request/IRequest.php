<?php

namespace Lavi\Request;

interface IRequest
{
    public function all();
    public function get(string $key);
    public function set(string $key, mixed $value);
    public function has(string $key);
    public function getUri();
}