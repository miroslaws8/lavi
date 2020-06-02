<?php

namespace models;

use bundles\Model;
use bundles\Redirector;
use bundles\Session;
use bundles\Validator;

class User extends Model
{
    protected $table = 'users';

    public static function get(string $login, string $password)
    {
        $where = [
            'name'    => $login,
            'password' => $password
        ];

        return static::getOne($where);
    }

    public static function signin(array $values) : bool
    {
        $user = self::get($values['name'], md5($values['password']));

        if (empty($user)) {
            $validator = new Validator();
            $validator->addError('user', 'Пользователь не найден!');
            return false;
        }

        static::update(['token' => md5($user['password'].time())],
            $user['id']
        );

        Session::set('user', $user);
        Session::set('token', $user->token);
        Session::doLogin();

        return true;
    }

    public static function signup(array $values) : bool
    {
        $data = $values;

        $data['password'] = md5($values['password']);
        $data['cdate']    = date('Y-m-d');
        $data['token']    = md5($values['password'].time());

        if (!empty(self::get($values['name'], $values['password']))) {
            $validator = new Validator();
            $validator->addError('user', 'Пользователь зарегистрирован');
            return false;
        }

        static::insert($values);

        return true;
    }
}