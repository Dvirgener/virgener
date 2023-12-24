<?php

declare(strict_types=1);

namespace App\config;

use Framework\App;
use App\Middleware\{TemplateDataMiddleware, ValidationExceptionMiddleware, SessionMiddleware, FlashMiddleware, CsrfTokenMiddleware, CsrfGuardMiddleware};

function registerMiddleware(App $app)
{
    // * 15. invoke addMiddleware Function of app class with the class names as arguements
    $app->addMiddleware(CsrfGuardMiddleware::class);
    $app->addMiddleware(CsrfTokenMiddleware::class);
    $app->addMiddleware(TemplateDataMiddleware::class);
    $app->addMiddleware(ValidationExceptionMiddleware::class);
    $app->addMiddleware(FlashMiddleware::class);
    $app->addMiddleware(SessionMiddleware::class);
}
