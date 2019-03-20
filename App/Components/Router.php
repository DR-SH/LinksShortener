<?php
namespace App\Components;

use Config\Routes;

/**
 * Class Router
 * @package App\Components
 */
class Router
{
    /**
     * Routes linked URI and controllers.
     *
     * @var array
     */
    private $routes;

    /**
     * Router constructor.
     */
    public function __construct(){
        $this->routes = Routes::get();
    }

    /**
     * Get the URI and call the relevant controller.
     */
    public function run(){
        $uri = trim($_SERVER['REQUEST_URI'], '/');
        $newRoute = 'link/index';
        foreach($this->routes as $key=>$array) {
            if(preg_match("#^$key$#", $uri)) {
                $newRoute = preg_replace("#$key#", $array, $uri);
                break;
            }
        }
        $segments = explode('/', $newRoute);
        $controller = ucfirst(array_shift($segments)).'Controller';
        $action='action'.ucfirst(array_shift($segments));
        $controllerFullPath = 'App\\Controllers\\'.$controller;
        $controllerObj = new $controllerFullPath;
        $result = $controllerObj->$action($segments);
    }

}