<?php


declare(strict_types=1);

require __DIR__ . "/../../vendor/autoload.php";

use Framework\App;
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
use App\Config\paths;
=======
>>>>>>> parent of c747191 (Update from my Laptop)
use function App\config\registerRoutes;
// use App\Controllers\HomeController;
// use App\Controllers\AboutPageController;

// 2 create app instance (go to app.php)
<<<<<<< HEAD
$app = new App(Paths::SOURCE . "App/container-definitions.php");
=======
$app = new App();
>>>>>>> parent of c747191 (Update from my Laptop)
registerRoutes($app);
// 4 run get method of app class (go to app.php)
// $app->get('/', [HomeController::class, 'home']);
// $app->get('/about', [AboutPageController::class, 'aboutPage']);
=======

$app = new App();

>>>>>>> parent of 360c17a (Progress)
=======

$app = new App();

>>>>>>> parent of 360c17a (Progress)
return $app;
