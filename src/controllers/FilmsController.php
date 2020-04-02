<?php

namespace controllers;

use bundle\Controller;
use bundle\Redirector;
use bundle\Session;
use bundle\View;
use models\Films;
use utils\Uploader;
use models\Session as Seance;
use models\Order;

class FilmsController extends Controller
{
    protected $neededFields = ['caption', 'description', 'poster'];

    protected function before()
    {
        if (!Session::getIsLoggedIn()) {
            Redirector::to('login/');
            return false;
        }

        $request = &$this->request->data;
        foreach ($request as $key => $value) {
            if (!in_array($key, $this->neededFields)) {
                throw new \Exception($key.' require field!');
            }

            if (!is_array($value)) {
                $request[$key] = htmlspecialchars($value);
            }
        }

        return true;
    }

    public function addAction()
    {
        $values = [
            'cdate' => date('Y-m-d H:i:s')
        ];

        $values = array_merge($this->request->data, $values);

        $dataFile = Uploader::uploadPicture(
            $values['poster'], 'films/', rand(0, 99999)
        );

        $values['poster'] = '/public/storage/films/'.$dataFile['basename'];

        Films::add($values);

        Redirector::to('/admin');
    }

    public function display()
    {
        View::render('film/page.php', [
            'film'     => Films::get($this->params['id']),
            'sessions' => Seance::getList(),
        ]);
    }

    public function editAction()
    {
        $request = $this->request->data;
        Films::edit($request, $this->params['id']);

        Redirector::to('/admin');
    }

    public function removeAction()
    {
        Films::remove($this->params['id']);

        Redirector::to('/admin');
    }
}