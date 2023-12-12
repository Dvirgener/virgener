<?php

// 2. we have included this file from the main index.php
declare(strict_types=1);
require __DIR__ . "/../../vendor/autoload.php";

use Framework\App;
use function App\config\registerRoutes;

// use App\Controllers\HomeController;
// use App\Controllers\AboutPageController;

// 2 create app instance (go to app.php)
$app = new App();

// this function registers routes for your application
registerRoutes($app);

return $app;
