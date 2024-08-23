<?php

namespace Core\Router;

use App\Classes\Request;
use App\Classes\Response;

class Router
{
    protected $routes;
    protected $method;
    protected $url;
    protected $query;
    protected $body;

    protected $request;
    protected $response;

    public function __construct()
    {
        $this->response = new Response();
        $this->method = request()->method();
        $this->url = request()->url();
        $this->query = request()->query();
        $this->body = request()->body();
        $this->loadStaticRoutes();
    }

    public function addRoute($method, $url, $callback)
    {
        return new SingleRoute($this,$method, $url, $callback);
    }

    public function setRoute(SingleRoute $route)
    {
        $this->routes[] = [
            'method' => $route->getMethod(),
            'url' => $route->getUrl(),
            'callback' => $route->getCallback(),
            'name' => $route->getName(),
            'middlewares' => $route->getMiddlewares()
        ];
    }

    public function get($url, $callback)
    {
        return $this->addRoute('GET', $url, $callback);
    }

    public function post($url, $callback)
    {
        return $this->addRoute('POST', $url, $callback);
    }

    public function getUniqueRouteName(): string
    {
        return uniqid();
    }


    public function getAllRoutes($method = null): array
    {
        $routes = $this->routes;
        if (empty($routes)) {
            $routes = $this->loadCustomRoutes();
        }
        $routes = array_merge(...$routes);
        return array_filter($routes, function ($value) use ($method) {
            $temp = true;
            if ($method) {
                $temp = $value['method'] == $method;
            }
            return !is_null($value) && $value !== '' && $value !== [] && $temp;
        });
    }

    public function loadCustomRoutes()
    {
        $routesFiles = [];
        $files = glob(app_path('Routes/*.php'));
        foreach ($files as $file) {
            $routeFile = require $file;
            $routesFiles[] = $routeFile->getRoutes();
        }
        return $routesFiles;
    }


    public function getRoutes()
    {
        if (is_null($this->routes)) {
            $this->routes = $this->loadCustomRoutes();
        }
        return $this->routes;
    }

    public function findRouteByUri($uri)
    {
        $routes = $this->getRoutes();


        foreach ($routes as $route) {
            $route = json_encode($route);
            $route = json_decode($route);
            foreach ($route as $key => $value) {
                $subRoute = json_decode(json_encode($value), true);
                if ($subRoute['url'] == $uri) {
                    if ($subRoute['method'] == $this->method || $subRoute['method'] == 'ANY'){
                        return $subRoute;
                    }
                }
            }
        }
        return null;
    }


    public function callAction()
    {
        $route = $this->findRouteByUri($this->url);
        if (is_null($route)) {
            $this->response->notFound()->send();
        }
        if (array_key_exists('callback', $route)) {
            if (is_array($route['callback'])){
                $controller = new $route['callback'][0];
                $action = $route['callback'][1];
                return $controller->$action($this->query, $this->body);
            }else{
                return $route['callback']($this->query, $this->body);
            }
        }
        return $this->response->notFound()->send();
    }

    protected function loadStaticRoutes()
    {
//        $this->routes[] = [];
    }

}