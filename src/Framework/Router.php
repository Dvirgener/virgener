<?php


declare(strict_types=1);

namespace Framework;


class Router
{

    private array $Routes = [];

    // 7 store the passed method, path and controller class here in this array
    public function add(string $method, string $path, array $controller)
    {
        // 8 normalize first before storing to routes array
        $path = $this->normalizePath($path);
        // 10 store the array with the values here (go back to index.php)
        $this->Routes[] = [
            'path' => $path,
            'method' => strtoupper($method),
            'controller' => $controller
        ];
    }
    //  9 this is the normalize function
    private function normalizePath(string $path): string
    {
        $path = trim($path, '/');
        $path = "/{$path}/";
        $path = preg_replace('#[/]{2,}#', '/', $path);

        return $path;
    }
    // 14 this is the dispatch function
    public function dispatch(string $path, string $method)
    {
        // 15 normalize the path and method
        $path = $this->normalizePath($path);
        $method = strtoupper($method);

        // 16 search for all the stored routes in the array of routes.
        foreach ($this->Routes as $route) {
            // 17 compare each route if it does not match with the path requested by the user
            if (!preg_match("#^{$route['path']}$#", $path) || $route['method'] !== $method) {
                // 18 if the condition is true continue to the next route in the array
                continue;
            }

            // 19 if false, instantiate the controller class based on the array of routes stored

            [$class, $function] = $route['controller'];

            $controllerInstance = new $class;
            // 20 invoke the method of the controller class (This is what will be displayed in the index.php file based on the controller class that was passed)
            $controllerInstance->{$function}();
        }
    }
}
