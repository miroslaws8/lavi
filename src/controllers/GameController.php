<?php

namespace controllers;

use bundle\Controller;
use bundle\Response;
use bundle\View;
use bundle\Session;
use bundle\Redirector;
use models\Game;
use models\User;

class GameController extends Controller
{
    public function before() : bool
    {
        if (!Session::getIsLoggedIn()) {
            Redirector::to('/signin');
            return false;
        }

        return true;
    }


    public function doIndex() : void
    {
        $idUser = Session::get('user')->id;

        $user   = User::getOne(['id' => $idUser]);

        $config = json_decode($user['settings'], true);

        if ($config === null) {
            throw new \Exception('Invalid settings');
        }

        View::render('game/index.php', [
            'configs'  =>$config,
            'settings' => $user['settings'],
            'token'    => $user['token']
        ]);
    }

    public function add() : void
    {
        $headers = getallheaders();

        $user = User::getOne(['token' => $headers['access-token']]);

        $request = $this->request->data();

        $rules = [
            'outside' => [
                'required' => true,
            ],
            'success' => [
                'required' => true
            ]
        ];

        $data = $this->validator->validate($request, $rules);

        $values = [
            'results' => json_encode($data),
            'cdate' => date('Y-m-d'),
            'id_user' => $user['id']
        ];

        $id = Game::add($values);

        $result = [
            'outside'  => $data['outside'],
            'success'  => $data['success'],
            'settings' => $user['settings']
        ];

        Response::send(['error' => false, 'data' => $result, 'id_game' => $id]);
    }

    public function doEndgame() : void
    {
        $params = $this->params;

        $gameData = Game::getOne(['id' => $params['id']]);

        if (Session::get('user')->id !== $gameData['id_user']) {
            throw new \Exception('Сюда нельзя без спроса!');
        }

        $results = json_decode($gameData['results'], true);

        if ($results === null) {
            throw new \Exception('Что-то пошло не так.');
        }

        $user = User::getOne(['id' => Session::get('user')->id]);
        $settings = json_decode($user['settings'], true);

        $data = [
            'settings' => $settings,
            'success' => $results['success'],
            'date'    => $gameData['cdate'],
            'outside' => $results['outside'],
        ];

        View::render('game/endgame.php', ['data' => $data]);
    }
}