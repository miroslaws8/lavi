<?php

namespace controllers;

use bundle\Controller;
use bundle\View;
use models\User;
use bundle\Session;

class HomeController extends Controller
{
    const ITEM_PER_PAGE = 3;

    public function index()
    {

        View::render('main/index.php', [
            'user' => Session::get('user')
        ]);
    }
}