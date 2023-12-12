<?php


declare(strict_types=1);
require __DIR__ . "/../../vendor/autoload.php";

use Framework\App;
use function App\config\registerRoutes;

// 2 create app instance (go to app.php)
$app = new App();

// 4 this function registers routes for your application
registerRoutes($app);

return $app;
