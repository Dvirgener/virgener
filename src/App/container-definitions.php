<?php

declare(strict_types=1);

use Framework\TemplateEngine;
use App\config\paths;

return [
    // * 2. returns an array with the instance of the template engine with the base path as a value (go to templateEngine.php)
    TemplateEngine::class => fn () => new TemplateEngine(Paths::VIEW)
];
