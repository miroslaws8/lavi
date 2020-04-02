<?php

namespace controllers;

use bundle\{Controller, Session, View};
use bundle\Redirector;
use models\Films;

class AdminController extends Controller
{
    public function before()
    {

        if (!Session::getUserID()) {
            Redirector::to('login/');
            return false;
        }

        return true;
    }

    public function indexAction()
    {
        $params = [
            'films' => Films::getList()
        ];

        View::render('admin/index.php', $params);
    }
}