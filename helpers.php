<?php


use App\Classes\View;
use Core\Filesystem\Paths;

function request($key = null, $method = 'get')
{
    if (!isset($GLOBALS['request'])) {
        $GLOBALS['request'] = new \App\Classes\Request();
    }
    $request = $GLOBALS['request'];
    if ($key == null) {
        return $request;
    }
    return $request->{$method}($key);
}

/**
 * @throws Exception
 */
function view($path, $data)
{
    $path = Paths::getViewPath() . $path;
    $path = string2path($path);
    return (new View)->make($path . '.php', $data)->render();

}

function template($template, $data)
{
    $templatePath = Paths::getViewPath() . 'Templates/' . $template . '.php';
    $checkFile = file_exists($templatePath);
    if (!$checkFile) {
        throw new Exception('Template not found');
    }

    require_once $templatePath;

    $template = 'App\\Views\\Templates\\' . $template;


    $templateClass = new $template;
    return $templateClass->handle($data);
}


/**
 * @param $string
 * @return string
 */
function string2path($string): string
{
    return str_replace([' ', '.'], ['/', '/'], $string);
}


function base_path()
{
    return __DIR__ . '/';
}

function public_path()
{
    return base_path() . 'Public/';
}

function storage_path($path = null)
{
    return base_path() . 'Storage/'. $path;
}

function app_path($path = null)
{
    return base_path() . 'App/' . $path;
}

function core_path($path = null)
{
    return base_path() . 'Core/' . $path;
}

/**
 * @param $path
 * @return string
 */
function view_path($path = null)
{
    if ($path) {
        return app_path() . 'Views/' . $path;
    }
    return app_path() . 'Views/';
}


/**
 * @param $path
 * @return \Core\Filesystem\File
 */
function files($path = null): \Core\Filesystem\File
{
    return (new \Core\Filesystem\File($path));
}


function config($path, $default = null)
{
    $explode = explode('.', $path);
    $array = $explode;
    if (count($array) == 1) {
        return require app_path() . 'Configs/' . string2path($path) . '.php';
    }
    $key = $array[count($array) - 1];
    array_pop($array);
    $path = implode('.', $array);
    $config = require app_path() . 'Configs/' . string2path($path) . '.php';
    if (!isset($config[$key])) {
        return $default;
    }
    return $config[$key];


}


function response()
{
    return new \App\Classes\Response();
}