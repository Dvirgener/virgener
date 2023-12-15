<?php

declare(strict_types=1);

namespace Framework;

class App
{

    private Router $router;
    private Container $container;

    // * 4. Construct method of App class that creates instance of the router and container classes
    // * if a container has value it will invoke the addDefinitions function with the base path as a value.
    public function __construct(string $containerDefinitionsPath = null)
    {
        $this->router = new Router();

        $this->container = new Container();
        if ($containerDefinitionsPath) {

            $containerDefinitions = include $containerDefinitionsPath;
            $this->container->addDefinitions($containerDefinitions);
        }
    }


    public function run()
    {
        // * 11. this is where the program will look for the requested URL and method of the user and store it in a variable as well as the instance of the container
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];
        $this->router->dispatch($path, $method, $this->container);
    }


    public function get(string $path, array $controller)
    {
        // * 8 store values of routes in the router class
        $this->router->add('GET', $path, $controller);
    }
}
