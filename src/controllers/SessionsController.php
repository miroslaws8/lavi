<?php

namespace controllers;

use bundle\Controller;
use models\Order;

class SessionsController extends Controller
{
    public function index()
    {
        $orders = Order::getByRow($this->request->data);

        $hall = [];
        for ($i = 1; $i <= 5; $i ++) {
            for ($n = 1; $n <= 10; $n++) {
                $hall[$i][$n] = $n;
            }
        }

        foreach ($orders as $key => $order) {
            if (!empty($hall[$order['row']][$order['place']])) {
                unset($hall[$order['row']][$order['place']]);
            }

            continue;
        }

        echo json_encode($hall[$this->request->data('row')]);
    }
}