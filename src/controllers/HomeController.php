<?php

namespace controllers;

use Lavi\Controller\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return ['id' => 1];
    }
}