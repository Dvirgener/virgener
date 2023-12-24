<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Services\{ValidatorService, UserService};


class LoginController
{

    public function __construct(private ValidatorService $ValidatorService, private TemplateEngine $view, private UserService $userService)
    {
    }

    public function loginView()
    {
        echo $this->view->render("login.php", ['title' => 'Log in']);
    }

    public function login()
    {
        $this->ValidatorService->validateLogin($_POST);
        $this->userService->loginUser($_POST);
        redirectTo('/');
    }
    public function logout()
    {
        $this->userService->logout();
        redirectTo('/login');
    }
}
