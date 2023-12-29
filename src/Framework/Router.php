<?php


declare(strict_types=1);

namespace Framework;



class Router
{

    private array $Routes = [];
    private array $middlewares = [];
    private array $errorHandler = [];

    // * 13. store them as array
    public function add(string $method, string $path, array $controller)
    {

        $path = $this->normalizePath($path);

        $regexPath = preg_replace('#{[^/]+}#','([^/]+)',$path);

        $this->Routes[] = [
            'path' => $path,
            'method' => strtoupper($method),
            'controller' => $controller,
            'middlewares' => [],
            'regexPath' => $regexPath
        ];
    }

    private function normalizePath(string $path): string
    {
        $path = trim($path, '/');
        $path = "/{$path}/";
        $path = preg_replace('#[/]{2,}#', '/', $path);

        return $path;
    }

    public function dispatch(string $path, string $method, Container $container = null)
    {
        // * 22. this is where you dispatch the requested URL of the user.
        $path = $this->normalizePath($path);
        $method = strtoupper($_POST['_METHOD'] ?? $method);

        // * 23. search the registered routes to look for the match in URL and method of the user request
        foreach ($this->Routes as $route) {
            if (!preg_match("#^{$route['regexPath']}$#", $path, $parameterValues) || $route['method'] !== $method) {
                continue;
            }

            array_shift($parameterValues);

            preg_match_all('#{([^/]+)}#',$route['path'],$paramKeys);

            $paramKeys = $paramKeys[1];
            $params = array_combine($paramKeys, $parameterValues);


            // * 24. if a match is found, create a new instance of a class or run the method resovle of the container class 
            // * the class variable came from the registered route matched with the user's requested URL
            [$class, $function] = $route['controller'];

            // * 42. store the instance of the class from the resolve method of the container class in controller instance variable
            $controllerInstance = $container ? $container->resolve($class) : new $class;

            // * 43. define an arrow function invoking the function of the class instance of the controllerinstancevariable
            $action = fn () => $controllerInstance->{$function}($params);

            $allMiddleware = [...$route['middlewares'], ...$this->middlewares];

            // * 44. run through registered middlewares 
            foreach ($allMiddleware as $middleWare) {
                $middlewareInstance = $container ? $container->resolve($middleWare) : new $middleWare;
                $action = fn () => $middlewareInstance->process($action);
            }

            $action();
            return;
        }

        $this->dispatchNotFound($container);
    }

    public function addMiddleware(string $middleWares)
    {
        // * 17. Store middlewares in this array
        $this->middlewares[] = $middleWares;
    }

    public function addRouteMiddleware(string $middleWare)
    {
        $lastRouteKey = array_key_last($this->Routes);
        $this->Routes[$lastRouteKey]['middlewares'][] = $middleWare;
    }

    public function setErrorHandler(array $controller){
        $this->errorHandler = $controller;


    }

    public function dispatchNotFound (?container $container){
        [$class,$function] = $this->errorHandler;
        $controllerInstance = $container ? $container->resolve($class) : new $class;
        $action = fn() => $controllerInstance->$function();
        foreach($this->middlewares as $middleWare){
            $middlewareInstance = $container ? $container->resolve($middleWare) : new $middleWare;
            $action = fn() => $middlewareInstance($action);
        }

        $action();
    }
}
