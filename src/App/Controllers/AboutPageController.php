<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\config\paths;


class AboutPageController
{

    public function __construct(private TemplateEngine $view)
    {
    }

    public function aboutPage()
    {
        echo $this->view->render("aboutPage.php", ['title' => 'About']);
    }
}
