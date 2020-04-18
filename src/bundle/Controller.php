<?php

namespace bundle;

abstract class Controller
{
    protected $params    = [];
    protected $request   = null;
    protected $validator = null;

    public function __construct($params)
    {
        Session::init();

        $this->request   = new Request();
        $this->validator = new Validator();
        $this->params    = $params;
    }

    public function request(string $key)
    {
        if (!array_key_exists($key, $this->request->data)) {
            return null;
        }

        return $this->request->data[$key];
    }

    public function __call($name, $args)
    {
        $method = 'do'.$name;
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