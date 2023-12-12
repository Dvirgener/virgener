<?php

declare(strict_types=1);

namespace Framework;

class App
{
<<<<<<< HEAD
<<<<<<< HEAD

    private Router $router;

    // 3 constructor to make instance of router class (go back to bootstrap.php)
    public function __construct()
    {
        $this->router = new Router();
    }

    // 12 parse the http request made by user here
    public function run()
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];
        // 13 invoke the dispatch method of the router class (go to router.php)
        $this->router->dispatch($path, $method);
    }

    // 5 this is the get method of app class
    public function get(string $path, array $controller)
    {
        // 6 add the method, path and controller (URL) (go to router.php)
        $this->router->add('GET', $path, $controller);
=======
    public function run()
    {
        echo "application is running!";
>>>>>>> parent of 360c17a (Progress)
=======
    public function run()
    {
        echo "application is running!";
>>>>>>> parent of 360c17a (Progress)
    }
}
