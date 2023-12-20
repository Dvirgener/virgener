<?php

declare(strict_types=1);

use Framework\TemplateEngine;
use App\config\paths;
use App\Services\ValidatorService;

return [
    // * 7. return an arrow function with the class name as key and function that create a new instance of the class as value
    TemplateEngine::class => fn () => new TemplateEngine(Paths::VIEW),
    ValidatorService::class => fn () => new ValidatorService()
];
