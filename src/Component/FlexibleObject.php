<?php

namespace Lavi\Component;

use Exception;
use Traversable;

class FlexibleObject implements \IteratorAggregate
{
    private $rawData = [];

    public static function create(callable $function)
    {
        return $function(new static());
    }

    public function mapRawData()
    {
        array_map(function ($item) {
            return new static($item);
        }, $this->rawData);
    }

    public function __constructor(array $data = [])
    {
        $this->rawData = $data;
    }

    public function setData(array $data): void
    {
        $this->rawData = $data;

        if (!is_array($data)) {
            return;
        }

        foreach ($data AS $key => $value) {
            if (!array_key_exists($key, get_object_vars($this)) === true) {
                continue;
            }

            if ($this->{$key} instanceof FlexibleObject) {
                if (is_array($value)) {
                    $this->{$key}->setData($value);
                    continue;
                }

                $this->{$key} = null;
                continue;
            }

            $this->{$key} = $value;
        }
    }

    public function getProp(string $key)
    {
        return $this->{$key};
    }

    public function getIterator()
    {
        return new \ArrayIterator($this);
    }

    public static function serialize(array $data): string
    {
        return json_encode($data);
    }

    public static function deserialize(string $str): array
    {
        return json_decode($str, true) ?: [];
    }

    public static function fromJSON(string $str)
    {
        return new static(static::deserialize($str));
    }
}