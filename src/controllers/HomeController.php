<?php

namespace controllers;

use bundle\Controller;
use bundle\View;

class HomeController extends Controller
{
    public function index()
    {
        View::render('main/index.php');
    }
}