<?php

namespace Lavi\Request;

class Request
{
    public $params = [
        "Controller" => null,
        "action"     => null,
        "args"       => null
    ];

    public $data  = [];
    public $query = [];
    public $url   = null;

    public function __construct()
    {
        $this->data    = $this->mergeData($_POST, $_FILES);
        $this->query   = $_GET;
    }

    public function addParams(array $params)
    {
        $this->params = array_merge($this->params, $params);
        return $this;
    }

    public function getUri()
    {
        return $_SERVER['QUERY_STRING'];
    }

    public function getQueries()
    {
        $queries = [];

        foreach ($_GET as $key => $value) {
            $queries[$key] = $this->getQuery($key);
        }

        return $queries;
    }

    public function getQuery(string $key)
    {
        if (!array_key_exists($key, $_GET)) {
            return null;
        }

        return htmlspecialchars($_GET[$key]);
    }

    private function mergeData(array $post, array $files)
    {
        foreach ($post as $key => $value) {
            if (is_string($value)) {
                $post[$key] = trim($value);
            }
        }

        $input = file_get_contents('php://input');

        $data = [];
        if (!empty($input) && json_decode($input, true) !== null) {
            $data = json_decode($input, true);
        }

        return array_merge($files, $post, $data);
    }

    public function data(string $key = null)
    {
        if (!$key) {
            return $this->data;
        }

        if (!array_key_exists($key, $this->data)) {
            return false;
        }

        return $this->data[$key];
    }

    public function getProtocol(){
        return $this->isSSL() ? 'https' : 'http';
    }

    public function getParam($key){
        return array_key_exists($key, $this->params) ? $this->params[$key] : null;
    }

    public function isPost()
    {
        return $_SERVER["REQUEST_METHOD"] === "POST";
    }

    public function isGet()
    {
        return $_SERVER["REQUEST_METHOD"] === "GET";
    }

    public function isSSL()
    {
        return array_key_exists('HTTPS', $_SERVER) &&
            !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== "off";
    }
}