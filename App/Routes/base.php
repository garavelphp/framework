<?php


use GaravelPHP\Router\Router;

$router = new Router();


$router->get('/', [\App\Controllers\HomeController::class, 'getHello'])
    ->setName('home')
    ->setMiddlewares('auth')
    ->save();

$router->post('/a', [\App\Controllers\ExapmleController::class, 'getHaello'])
    ->setName('home')
    ->setMiddlewares('auth')
    ->save();


return $router;