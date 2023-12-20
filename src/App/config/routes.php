<?php

declare(strict_types=1);

namespace App\config;

use Framework\App;

use App\Controllers\{HomeController, AboutPageController, RegisterUserController};



function registerRoutes(App $app)
{
    // * 11. run get/post methods of the app class to store these values to the router class
    $app->get('/', [HomeController::class, 'home']);
    $app->get('/about', [AboutPageController::class, 'aboutPage']);
    $app->get('/register', [RegisterUserController::class, 'registerView']);
    $app->post('/register', [RegisterUserController::class, 'register']);
}
