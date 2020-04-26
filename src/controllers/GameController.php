<?php

namespace controllers;

use bundle\Controller;
use bundle\View;
use bundle\Session;
use models\User;

class GameController extends Controller
{
    public function index() : void
    {
        $idUser = Session::get('user')->id;
        $user   = User::getOne(['id' => $idUser]);

        $config = json_decode($user['settings'], true);

        if ($config === null) {
            throw new \Exception('Invalid settings');
        }

        View::render('game/index.php', [
            'configs' =>$config
        ]);
    }

    public function endgame() : void
    {
        View::render('game/endgame.php');
    }
}