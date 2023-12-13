<?php

declare(strict_types=1);

namespace Framework;

class App
{

    private Router $router;
    private Container $container;


    public function __construct(string $containerDefinitionsPath = null)
    {
        // 3. construct method to create a new instance of the router class which will be responsible for routing users URL requests
        $this->router = new Router();
        $this->container = new Container();

        if ($containerDefinitionsPath) {
            $containerDefinitions = include $containerDefinitionsPath;
            $this->container->addDefinitions($containerDefinitions);
        }
    }

    // 12 parse the http request made by user here
    public function run()
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];
        // 13 invoke the dispatch method of the router class (go to router.php)
        $this->router->dispatch($path, $method, $this->container);
    }

    public function get(string $path, array $controller)
    {
        // 6. add the method, path and controller (URL) (go to router.php)
        $this->router->add('GET', $path, $controller);
    }
}
