<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;
use Framework\TemplateEngine;

class FlashMiddleware implements MiddlewareInterface
{
    public function __construct(private TemplateEngine $view)
    {
    }
    public function process(callable $next)
    {
        // * 49. add a global variable errors with session error key as value
        $this->view->addGlobal('errors', $_SESSION['errors'] ?? []);
        // * 50. unset the errors after displaying it
        unset($_SESSION['errors']);

        $this->view->addGlobal('oldFormData', $_SESSION['oldFormData'] ?? []);
        // * 50. unset the errors after displaying it
        unset($_SESSION['oldFormData']);

        $next();
    }
}
