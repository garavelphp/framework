<?php

namespace Core\Router;

class SingleRoute
{

    public string $method;
    public string $url;
    public $callback;
    public string $name;
    public array $middlewares;

    public string $controller;

    public $function;
    public Router $router;

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

    public function getUrl():string
    {
        return $this->url;
    }

    public function getCallback()
    {
        return $this->callback;
    }

    public function getName():string
    {
        return $this->name;
    }

    public function getMiddlewares():array
    {
        return $this->middlewares;

    }

    public function setMethod($method): SingleRoute
    {
        $this->method = $method;
        return $this;

    }

    public function setUrl(string $url): SingleRoute
    {
        $this->url = $url;
        return $this;

    }

    public function setCallback($callback): SingleRoute
    {
        $this->callback = $callback;
        return $this;

    }

    public function setName(string $name): SingleRoute
    {
        $this->name = $name;
        return $this;
    }

    public function setMiddlewares($middlewares): SingleRoute
    {
        if (!is_array($middlewares)) {
            $middlewares = [$middlewares];
        }
        $this->middlewares = $middlewares;
        return $this;

    }

    public function save() : void
    {
        $this->router->setRoute($this);
    }

    public function toArray():array
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