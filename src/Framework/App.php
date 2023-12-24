<?php

declare(strict_types=1);

namespace Framework;

class App
{

    private Router $router;
    private Container $container;


    public function __construct(string $containerDefinitionsPath = null)
    {
        // * 3. Create a new instance of the Router class
        $this->router = new Router();

        // * 4. Create a new instance of the container class
        $this->container = new Container();
        // * 5. if the constructor class is not null, 
        if ($containerDefinitionsPath) {
            // * 6. get the returned data from the container-definitions file as an array.
            $containerDefinitions = include $containerDefinitionsPath;
            // * 8. Add the arrow functions to the AddDefinitions method of the container class
            $this->container->addDefinitions($containerDefinitions);
        }
    }


    public function run()
    {
        // * 20. this is where the program will look for the requested URL and method of the user and store it in a variable as well as the instance of the container
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];
        // * 21. invoke the dispatch method of the router class with the user inputted values as arguement
        $this->router->dispatch($path, $method, $this->container);
    }


    public function get(string $path, array $controller): App
    {
        // * 12. store values of routes in the router class
        $this->router->add('GET', $path, $controller);

        return $this;
    }

    public function post(string $path, array $controller): App
    {
        // * 12. store values of routes in the router class
        $this->router->add('POST', $path, $controller);

        return $this;
    }

    public function addMiddleware(string $middleWares)
    {
        // *16. invoke the addmiddleware function of the router
        $this->router->addMiddleware($middleWares);
    }

    public function add(string $middleware)
    {
        $this->router->addRouteMiddleware($middleware);
    }
}
