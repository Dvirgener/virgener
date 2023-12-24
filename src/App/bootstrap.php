<?php


declare(strict_types=1);
require __DIR__ . "/../../vendor/autoload.php";

use Framework\App;
use App\config\paths;
use Dotenv\Dotenv;
use function App\config\{registerRoutes, registerMiddleware};

$dotenv = Dotenv::createImmutable(Paths::ROOT);
$dotenv->load();

// * 2. Create a new instance of the App class with the container-definitions as constructor arguement
$app = new App(paths::SOURCE . "App/container-definitions.php");

// * 10. Register routes
registerRoutes($app);
// * 14. Register Middlewares
registerMiddleware($app);

// * 18. return the app class to index.php
return $app;
