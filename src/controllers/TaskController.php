<?php

namespace controllers;

use bundle\Controller;
use bundle\Response;
use models\Task;

class TaskController extends Controller
{
    const STATUS_NEW = 'new';

    public function index()
    {

    }

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
}