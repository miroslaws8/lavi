<?php

namespace models;

use bundle\Model;

class User extends Model
{
    public function get(string $login, string $password)
    {
        $db = Model::getConnection();
        static::$table = 'users';

        $db->prepare(
            'SELECT * FROM '.static::$table.
            ' WHERE login = "'.$login.'" AND password = "'.$password.'"'
        );

        $db->execute();

        return $db->fetchAssociative();
    }
}