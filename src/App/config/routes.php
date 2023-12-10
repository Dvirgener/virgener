<?php

declare(strict_types=1);

namespace App\config;

use Framework\App;

use App\Controllers\HomeController;
use App\Controllers\AboutPageController;

function registerRoutes(App $app)
{
    $app->get('/', [HomeController::class, 'home']);
    $app->get('/about', [AboutPageController::class, 'aboutPage']);
}
