<?php

namespace controllers;

use bundle\Controller;
use bundle\Redirector;
use models\Order;

class OrderController extends Controller
{
    public function add()
    {
        $request = $this->request->data;

        Order::add($request);

        Redirector::to('films/'.$request['id_film']);
    }
}