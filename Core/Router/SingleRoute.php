<?php

namespace Core\Router;

class SingleRoute
{

    public $method;
    public $url;
    public $callback;
    public $name;
    public $middlewares;

    public $controller;

    public $function;
    public $router;

    public function __construct(Router $router, $method, $url, $callback)
    {
        $this->router = $router;
        $this->method = $method;
        $this->url = $url;
        $this->callback = $callback;
        if (is_array($callback)) {
            $this->controller = $callback[0];
            $this->function = $callback[1];
        }
    }


    public function getMethod()
    {
        return $this->method;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getCallback()
    {
        return $this->callback;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getMiddlewares()
    {
        return $this->middlewares;

    }

    public function setMethod($method)
    {
        $this->method = $method;
        return $this;

    }

    public function setUrl($url)
    {
        $this->url = $url;
        return $this;

    }

    public function setCallback($callback)
    {
        $this->callback = $callback;
        return $this;

    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setMiddlewares($middlewares)
    {
        $this->middlewares = $middlewares;
        return $this;

    }

    public function save()
    {
        $this->router->setRoute($this);
    }

    public function toArray()
    {
        return [
            'method' => $this->method,
            'url' => $this->url,
            'callback' => $this->callback,
            'name' => $this->name,
            'middlewares' => $this->middlewares
        ];
    }

    public function __toString()
    {
        return json_encode($this->toArray());
    }


}