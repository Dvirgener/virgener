<?php


declare(strict_types=1);

namespace Framework;


class Router
{

    private array $Routes = [];

    // * 9. store them as array
    public function add(string $method, string $path, array $controller)
    {

        $path = $this->normalizePath($path);

        $this->Routes[] = [
            'path' => $path,
            'method' => strtoupper($method),
            'controller' => $controller
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
        // * 12 this is where you dispatch the requested URL of the user.
        $path = $this->normalizePath($path);
        $method = strtoupper($method);

        // * 13 search the registered routes to look for the match in URL and method of the user request
        foreach ($this->Routes as $route) {
            if (!preg_match("#^{$route['path']}$#", $path) || $route['method'] !== $method) {
                continue;
            }

            // * 14 if a match is found, create a new instance of a class or run the method resovle of the container class 
            [$class, $function] = $route['controller'];

            $controllerInstance = $container ? $container->resolve($class) : new $class;

            $controllerInstance->{$function}();
        }
    }
}
