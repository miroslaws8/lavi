<?php

namespace controllers;

use bundle\Controller;
use bundle\Redirector;
use bundle\View;
use models\Films;
use models\Order;
use models\Session;

class HomeController extends Controller
{
    public function index()
    {
        $values = [
            'popularFilms' => Films::getPopular(),
            'films'        => Films::getList('cdate DESC'),
            'sessions'     => Session::getList()
        ];

        View::render('main/index.php', $values);
    }
}