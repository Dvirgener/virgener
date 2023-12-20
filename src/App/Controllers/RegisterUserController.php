<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Services\ValidatorService;


class RegisterUserController
{

    public function __construct(private ValidatorService $ValidatorService, private TemplateEngine $view)
    {
    }

    public function registerView()
    {
        echo $this->view->render("register.php", ['title' => 'Registration']);
    }

    public function register()
    {
        $this->ValidatorService->validateRegister($_POST);
    }
}
