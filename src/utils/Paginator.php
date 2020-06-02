<?php

namespace utils;

use bundles\Request;
use bundles\View;

class Paginator
{
    private $pageQuery = 'page';

    public function render(int $current, int $total)
    {
        View::render('layouts/pagination/signup.php', [
            'current'  => $current,
            'total'    => $total,
            'instance' => $this
        ]);
    }

    public function getUrl(int $numPage)
    {
        $request = new Request();

        $queries = $request->getQueries();

        $queries[$this->pageQuery] = $numPage;

        return http_build_query($queries) . "\n";
    }

    public function setPageQuery(string $name)
    {
        $this->pageQuery = $name;
    }
}