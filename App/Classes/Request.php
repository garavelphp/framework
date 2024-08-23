<?php

namespace App\Classes;

class Request
{
    public function __construct()
    {
        $GLOBALS['request'] = $this;
    }

    public function get($key)
    {
        return $_GET[$key] ?? null;
    }

    public function post($key)
    {
        return $_POST[$key] ?? null;
    }


    public function body($key=null)
    {
        $body = json_decode(file_get_contents('php://input'), true);
        if($key == null){
            return $body;
        }
        return $body[$key] ?? null;
    }


    public function all(): array
    {
        return $_REQUEST;
    }

    public function method()
    {
        return $_SERVER['REQUEST_METHOD'] ?? 'GET';
    }

    public function url()
    {
        return $_SERVER['REQUEST_URI'] ?? '/';
    }

    public function query(): array
    {
        return $_GET;
    }

    public function header($key)
    {
        return getallheaders()[$key] ?? null;
    }

    public function ip()
    {
        return $_SERVER['REMOTE_ADDR'];
    }

    public function userAgent()
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    public function referer()
    {
        return $_SERVER['HTTP_REFERER'];
    }

    public function isAjax()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

    public function isJson(): bool
    {
        return isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false;
    }

    public function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    public function isGet(): bool
    {
        return $_SERVER['REQUEST_METHOD'] == 'GET';
    }

}