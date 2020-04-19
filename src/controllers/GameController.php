<?php

namespace controllers;

use bundle\Controller;
use bundle\View;

class GameController extends Controller
{
    public function index() : void
    {
        View::render('game/index.php');
    }
}