<?php
require 'vendor/autoload.php';
require 'Core/core.php';

use App\Classes\Handler;
use App\Classes\Request;
use Core\Cache\Base\Cache;
use Core\Router\Router;


define('PROCESS_START', microtime(true));
ini_set('display_errors', false);

$cache = new Cache();
$router = new Router();
$handler = new Handler();

try {
    $handler->terminate(function () use ($router) {
        try {
            return $router->callAction();

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    });
} catch (Exception $e) {
    $handler->log([
        'message' => $e->getMessage(),
        'code' => $e->getCode(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'trace' => $e->getTraceAsString()
    ]);

}


