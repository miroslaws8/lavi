<?php

namespace Lavi\Controller;

use Lavi\Exceptions\LaviException;
use Lavi\Request\IRequest;

abstract class Controller
{
    private const PREFIX = 'do';
    protected array $params = [];
    protected IRequest $request;
    protected $validator = null;

    public function __construct(...$params)
    {
        $this->params = $params;
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
        $method = self::PREFIX.$name;
        if (!method_exists($this, $method)) {
<<<<<<< HEAD
            throw new LaviException("Method $name not found in controller " . get_class($this));
        }

        $this->before();
        call_user_func_array([$this, $method], $args);
        $this->after();
    }

    protected function before(): void
    {
    }

    protected function after(): void
=======
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
>>>>>>> 56ac62db66b27e87cc991fc296d67446e4649ec7
    {
    }
}