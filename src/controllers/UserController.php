<?php

namespace controllers;

use bundle\Controller;
use bundle\Redirector;
use bundle\Session;
use bundle\View;
use models\User;

class UserController extends Controller
{
    public function before() : bool
    {
        if (Session::getIsLoggedIn()) {
            Redirector::root();
            return false;
        }

        return true;
    }

    public function logout() : bool
    {
        if (!Session::getIsLoggedIn()) {
            Redirector::root();
            return false;
        }

        Session::logout();

        Redirector::to('/');

        return true;
    }

    public function doIndex() : void
    {
        View::render('login/signup.php');
    }

    public function doDisplaySignin() : void
    {
        View::render('login/signin.php');
    }

    public function doSignin()
    {
        $request = $this->request->data();

        $rules = [
            'name' => [
                'required' => true,
            ],
            'password' => [
                'required' => true
            ]
        ];

        $data = $this->validator->validate($request, $rules);

        if (!User::signin($data)) {
            $this->validator->addError(
                'signup',
                'Пользлватель не найден'
            );

            Redirector::to('/signin');
            return false;
        }

        Redirector::to('/');

        return true;
    }

    public function doSignup()
    {
        $request = $this->request->data();

        $rules = [
            'name' => [
                'required' => true,
            ],
            'password' => [
                'required' => true
            ]
        ];

        $data = $this->validator->validate($request, $rules);

        if (!User::signup($data)) {
            $this->validator->addError(
                'signup',
                'Не удалось зарегистрироваться.'
            );


            Redirector::to('/signup');
            return false;
        }

        Redirector::to('/signin');
    }
}