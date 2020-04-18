<?php

namespace controllers;

use bundle\Controller;
use bundle\Redirector;
use bundle\Response;
use bundle\Session;
use models\Task;

class TaskController extends Controller
{
    const STATUS_NEW = 'new';

    public function add()
    {
        $request = $this->request->data();

        $rules = [
            'author' => [
                'required' => true,
            ],
            'email' => [
                'required' => true,
                'email'    => true,
            ],
            'text' => [
                'required' => true
            ]
        ];

        $data  = $this->validator->validate($request, $rules);
        $error = $this->validator->getError();

        if ($error) {
            Response::send([
                'error'   => true,
                'message' => $error
            ]);

            return false;
        }

        $data['status'] = static::STATUS_NEW;
        $data['cdate']  = date('Y-m-d H:i:s');

        Task::add($data);
        Response::send([
            'error'   => false,
            'message' => 'Successful task creation!'
        ]);

        return true;
    }

    public function before()
    {
        if (!Session::getUserID()) {
            throw new \Exception('You are not logged in');
        }

        return true;
    }

    public function doEdit()
    {
        $data  = $this->getEditData();
        $error = $this->validator->getError();

        if ($error) {
            Response::send([
                'error'   => true,
                'message' => $error
            ]);

            return false;
        }

        $idTask = $this->params['id'];

        $data['edited'] = (int) $this->getEditedStatus($data, $idTask);
        $data['mdate']  = date('Y-m-d H:i:s');

        Task::edit($data, $idTask);

        Redirector::to('/admin');

        return true;
    }

    private function getEditedStatus($data, $id)
    {
        $task = Task::get($id);

        if (empty($task)) {
            throw new \Exception('Not found task!');
        }

        return $task['text'] == $data['text'] ? 0 : 1;
    }

    private function getEditData()
    {
        $request = $this->request->data();
        $rules   = [
            'author' => [
                'required' => true,
            ],
            'email' => [
                'required' => true,
                'email'    => true,
            ],
            'text' => [
                'required' => true
            ],
            'status' => [
                'required' => true
            ]
        ];

        return $this->validator->validate($request, $rules);
    }
}