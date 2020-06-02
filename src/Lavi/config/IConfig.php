<?php

namespace Lavi\Config;

interface IConfig
{
    public function set(array $data): void;
    public function getPathPrefix(string $prefix): string;
    public function setPathPrefix(string $prefix): void;
}