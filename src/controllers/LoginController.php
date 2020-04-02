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
        if (Session::getUserID()) {
            Redirector::to('/admin');
        }

        View::render('layouts/login/index.php');
    }

    public function signin() : void
    {
        $login     = $this->request->data("login");
        $password  = $this->request->data("password");

        $user = User::get($login, md5($password));

        if ($user) {
            Session::set('is_logged_in', true);
            Session::set('user_id', $user['id']);

            Redirector::to('admin');
        }

        Redirector::to('/');
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