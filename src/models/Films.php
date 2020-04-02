<?php

namespace models;

use bundle\Model;

class Films extends Model
{
    public static function getList()
    {
        $db = Model::getConnection();
        static::$table = 'films';

        return $db->getAll('cdate DESC');
    }

    public function getPopular()
    {
        $db = Model::getConnection();
        static::$table = 'films';

        $sql = 'SELECT *, f.id as id_film, COUNT(o.id_film) as total 
                  FROM `'.static::$table.'` as f 
                  LEFT JOIN `orders` as o 
                    ON f.id = o.id_film 
                    GROUP BY f.id 
                    ORDER BY total DESC LIMIT 5;';

        $db->prepare($sql);
        $db->execute();

        return $db->fetchAllAssociative();
    }

    public function get($id)
    {
        $db = Model::getConnection();
        static::$table = 'films';

        return $db->getById($id);
    }

    public static function add(array $values)
    {
        $db = Model::getConnection();
        static::$table = 'films';
        $db->insert($values);
    }

    public static function edit(array $values, int $id)
    {
        $db = Model::getConnection();
        static::$table = 'films';
        $db->update($values, $id);
    }

    public static function remove(int $id)
    {
        $db = Model::getConnection();
        static::$table = 'films';
        $db->delete($id);
    }
}