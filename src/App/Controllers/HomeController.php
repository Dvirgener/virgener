<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\config\paths;


class HomeController
{

    public function __construct(private TemplateEngine $view)
    {
        // $this->view = new TemplateEngine(paths::VIEW);
    }

    public function home()
    {
        echo $this->view->render("/index.php", ['title' => 'HOME PAGESSS']);
    }
}
