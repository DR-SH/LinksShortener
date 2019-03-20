<?php
namespace App\Components;

use Config\Routes;

class Router
{
    private $routes;

    public function __construct(){
        $this->routes = Routes::get();

    }

    public function run(){
        $uri = trim($_SERVER['REQUEST_URI'], '/');
        $newRoute = 'link/index';
        foreach($this->routes as $key=>$array){
            if(preg_match("#^$key$#", $uri)){
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