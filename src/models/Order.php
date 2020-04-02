<?php

namespace models;

use bundle\Model;

class Order extends Model
{
    public static function add($values)
    {
        $db = Model::getConnection();
        static::$table = 'orders';
        $db->insert($values);
    }

    public static function getList()
    {
        $db = Model::getConnection();
        static::$table = 'orders';

        return $db->getAll();
    }

    public static function getByRow($values)
    {
        $db = Model::getConnection();
        static::$table = 'orders';

        $db->prepare('SELECT * FROM '.static::$table.
            ' WHERE id_film = :idFilm 
                AND id_session = :idSession AND row = :row');

        $db->execute($values);

        return $db->fetchAllAssociative();
    }
}