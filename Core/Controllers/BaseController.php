<?php

namespace Core\Controllers;

use ReflectionMethod;

class BaseController
{

    protected $prefix;


    public function response()
    {

    }


    /**
     * @throws \ReflectionException
     */
    public function getRoutes(): array
    {
        $thisClassFunctions = get_class_methods($this);
        $availableMethods = $this->hiddenMethods($thisClassFunctions);
        $routes = [];
        foreach ($availableMethods as $function) {
            $method = $this->findMethod($function);
            if (!$method) {
                continue;
            }
            $routes[] = $this->setRoute($function);
        }
        return $routes;
    }

    public function hiddenMethods($methods = [])
    {
        $hiddenMethods = ['getRoutes', 'getTemplate'];
        foreach ($hiddenMethods as $hiddenMethod) {
            $key = array_search($hiddenMethod, $methods);
            if ($key !== false) {
                unset($methods[$key]);
            }
        }
        return $methods;
    }


    public function findMethod($function)
    {
        return $this->isStartWith($function, ['get', 'post']);
    }

    public function isStartWith($string, $array)
    {
        foreach ($array as $item) {
            $itemLength = strlen($item);
            $trimmedString = substr($string, 0, $itemLength);
            if ($trimmedString == $item) {
                return strtoupper($item);
            }
        }
        return false;
    }

    public function setRoute($function)
    {
        $method = new ReflectionMethod($this, $function);
        $parameters = $method->getParameters();
        $prefix = $this->prefix ? '/' . $this->prefix . '/' : '/';

        $url = $this->convert2url($prefix, $function);
        return [
            'url' => $url,
            'function' => $function,
            'params' => array_map(function ($param) {
                return $param->getName();
            }, $parameters),
            'paramCount' => count($parameters),
            'method' => $this->findMethod($function),
            'controller' => get_class($this),
            'full_url' => config('app.url') . $url
        ];
    }

    public function convert2url($prefix, $function)
    {
        $url = $prefix . $this->camelToKebab(
                $this->removeMethodOnTheFunc($function)
            );
        $count = substr_count($url, '//');
        foreach (range(0, $count) as $item) {
            $url = str_replace('//', '/', $url);
        }
        return $url;


    }


    public function removeMethodOnTheFunc($function): string
    {
        $getStart = $this->isStartWith($function, ['get', 'post']);
        if (!$getStart) {
            return $function;
        }
        return substr($function, strlen($getStart));
    }


    public function camelToKebab($input)
    {
        $pattern = '/([a-z0-9])([A-Z])/';
        $replacement = '$1-$2';
        $kebabCase = preg_replace($pattern, $replacement, $input);
        return strtolower($kebabCase);
    }
}