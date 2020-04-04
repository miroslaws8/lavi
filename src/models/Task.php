<?php

namespace models;

use bundle\Model;

class Task extends Model
{
    protected $table = 'tasks';

    public static function getPaginateList($offset, $limit)
    {
        return static::pagination($offset, $limit, null, 'cdate DESC');
    }

    public static function getList()
    {
        return static::getAll('cdate DESC');
    }

    public static function add(array $values)
    {
        return static::insert($values);
    }
}