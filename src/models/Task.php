<?php

namespace models;

use bundle\Model;

class Task extends Model
{
    protected $table = 'tasks';

    public static function getPaginateList($offset, $limit, $orderBy)
    {
        return static::pagination($offset, $limit, null, $orderBy);
    }

    public static function getList()
    {
        return static::getAll(null, 'cdate DESC');
    }

    public static function edit(array $values, int $id)
    {
        return static::update($values, $id);
    }

    public static function add(array $values)
    {
        return static::insert($values);
    }

    public static function get($id)
    {
        $where = [
            'id' => $id
        ];

        return static::getOne($where);
    }
}