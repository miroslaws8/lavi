<?php

namespace Lavi\Config;

use Lavi\Config\Exceptions\ConfigException;

/**
 * Class Config
 * @package Lavi\Config
 */
class Config
{
    /**
     * @var array
     */
    protected array $data = [];

    /**
     * @param string $file
     * @return array
     * @throws ConfigException
     */
    public function load(string $file): array
    {
        try {
            $data = require $file;
        } catch (\Exception $exception) {
            throw new ConfigException($exception->getMessage());
        }

        return (array) $data;
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->data;
    }

    /**
     * @param string $key
     * @return mixed
     * @throws ConfigException
     */
    public function get(string $key)
    {
        if (!array_key_exists($key, $this->data)) {
            throw new ConfigException('Not found param');
        }

        return $this->data[$key];
    }
}