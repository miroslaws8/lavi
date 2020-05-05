<?php

namespace models;

use bundle\Model;
use bundle\Redirector;
use bundle\Session;
use bundle\Validator;

class Game extends Model
{
    protected $table = 'games';

    public static function add($values)
    {
        return static::insert($values);
    }
}