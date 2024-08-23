<?php

namespace Core\Commands\SystemCommands\Routes;

use Core\Commands\Base\BaseCommand;
use Core\Router\Router;

class RouteCommand extends BaseCommand
{


    /**
     * Your command signature
     * @var string Command signature
     */
    public $signature = 'route:list';

    /**
     * Your command description
     * @var string Command description
     */
    public $description = 'List all routes';

    /**
     * Your command handler
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        $router = new Router();
        $routes = $router->getAllRoutes();
        $rows = [];
        foreach ($routes as $route) {

            $route = (object)$route;
            $rows[] = [
                $route->method,
                $route->name,
                $route->url,
                is_array($route->callback) ? $route->callback[1] : '',
                is_array($route->callback) ? $route->callback[0] : ''
            ];
        }
        $this->table(['Method', 'Name','URL', 'Function', 'Controller'], $rows);
    }
}