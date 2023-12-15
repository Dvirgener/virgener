<?php


declare(strict_types=1);
require __DIR__ . "/../../vendor/autoload.php";

use Framework\App;
use App\config\paths;
use function App\config\registerRoutes;


// * 1. this command bootstraps our program and create instance of the app class with the container-definitions as arguement (go to container-definitions.php)
$app = new App(paths::SOURCE . "App/container-definitions.php");

// *6. Register Routes for the app
registerRoutes($app);


return $app;
