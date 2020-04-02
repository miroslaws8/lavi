<?php

namespace models;

use bundle\Model;

class Session extends Model
{
    public static function getList()
    {
        $db = Model::getConnection();
        static::$table = 'sessions';

        return $db->getAll();
    }
}