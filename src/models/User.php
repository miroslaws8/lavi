<?php

namespace models;

use bundle\Model;
use bundle\Session;

class User extends Model
{
    protected $table = 'users';

    public static function get(string $login, string $password)
    {
        $where = [
            'login'    => $login,
            'password' => $password
        ];

        return static::getOne($where);
    }
}