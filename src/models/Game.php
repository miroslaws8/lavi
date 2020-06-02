<?php

namespace models;

use bundles\Model;
use bundles\Redirector;
use bundles\Session;
use bundles\Validator;

class Game extends Model
{
    protected $table = 'games';

    public static function add($values)
    {
        return static::insert($values);
    }
}