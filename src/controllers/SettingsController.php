<?php

namespace controllers;

use bundle\Controller;
use bundle\Redirector;
use bundle\Session;
use bundle\View;
use models\User;

class SettingsController extends Controller
{
    public function before()
    {
        if (!Session::getIsLoggedIn()) {
            Redirector::to('/signin');
            return false;
        }

        return true;
    }

    public function doIndex()
    {
        $idUser = Session::get('user')->id;
        $user   = User::getOne(['id' => $idUser]);

        $settings = json_decode($user['settings'], true);

        if ($settings === null) {
            $settings = [];
        }

        View::render('settings/index.php', [
            'settings' => $settings
        ]);
    }

    public function doAddSettings()
    {
        $request = $this->request->data();
        $idUser  = Session::get('user')->id;

        User::update(['settings' => json_encode($request)], $idUser);

        Redirector::to('/game');
        return true;
    }
}