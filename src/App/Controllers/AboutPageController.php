<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\config\paths;


class AboutPageController
{
    private TemplateEngine $view;
    public function __construct()
    {
        $this->view = new TemplateEngine(paths::VIEW);
    }

    public function aboutPage()
    {
        echo $this->view->render("aboutPage.php", ['title' => 'About Page']);
    }
}
