<?php

namespace controllers;

use bundle\Controller;
use bundle\Redirector;
use bundle\View;
use models\Films;
use models\Order;
use models\Session;
use models\Task;
use utils\Paginator;

class HomeController extends Controller
{
    const ITEM_PER_PAGE = 3;

    public function index()
    {
        $page = $this->request->getQuery('page') ?? 1;

        $offset = ($page - 1) * static::ITEM_PER_PAGE;

        $taskList = Task::getPaginateList($offset, static::ITEM_PER_PAGE);

        View::render('main/index.php', [
            'tasks'       => $taskList['items'],
            'cntPage'     => $taskList['cntPage'],
            'currentPage' => $page
        ]);
    }
}