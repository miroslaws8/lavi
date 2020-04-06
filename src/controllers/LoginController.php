<?php

namespace controllers;

use bundle\Controller;
use bundle\Redirector;
use bundle\Session;
use bundle\View;
use models\User;

class LoginController extends Controller
{
    public function index()
    {
        $values = [];

        $error = $this->validator->getError('login');

        if ($error) {
            $values['error'] = $error;
        }

        if (Session::getUserID()) {
            Redirector::to('/admin');
        }

        View::render('layouts/login/index.php', $values);
    }

    public function signin()
    {
        $login     = $this->request->data("login");
        $password  = $this->request->data("password");

        $user = User::get($login, md5($password));

        if (empty($user)) {
            $this->validator
                ->addError('login', 'Введенные данные не верны!');

            Redirector::to('/login');

            return true;
        }

        Session::set('is_logged_in', true);
        Session::set('user_id', $user['id']);

        Redirector::to('/admin');

        return true;
    }

    public function logout() : void
    {
        if (!Session::getUserID()) {
            throw new \Exception('You are not logged in');
        }

        Session::logout();

        Redirector::to('login');
    }
}