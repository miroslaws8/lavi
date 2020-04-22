<?php

namespace controllers;

use bundle\Controller;
use bundle\View;
use models\User;
use bundle\Session;

class HomeController extends Controller
{
    public function index()
    {
        View::render('main/index.php', [
            'user' => Session::get('user')
        ]);
    }
}