<?php

declare(strict_types=1);

namespace App\config;

use Framework\App;

use App\Controllers\HomeController;
use App\Controllers\AboutPageController;

function registerRoutes(App $app)
{
    // 5. this is where you register your routes. the firs parameter of the get function is the URL requested by the User, 2nd param is the controller
    $app->get('/', [HomeController::class, 'home']);
    $app->get('/about', [AboutPageController::class, 'aboutPage']);
}
