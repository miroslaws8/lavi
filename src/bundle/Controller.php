<?php

namespace bundle;

abstract class Controller
{
    protected $route_params = [];
    protected $request;

    public function __construct($params)
    {
        Session::init();

        $this->request = new Request();
        $this->params  = $params;
    }

    public function __call($name, $args)
    {
        $method = $name . 'Action';
        if (!method_exists($this, $method)) {
            throw new \Exception("Method $name not found in controller " . get_class($this));
        }

        if ($this->before() !== false) {
            call_user_func_array([$this, $method], $args);
            $this->after();
        }
    }

    protected function before()
    {
    }

    protected function after()
    {
    }
}