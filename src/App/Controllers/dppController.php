<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\config\paths;
use App\Services\{dppService};


class dppController
{

    public function __construct(private TemplateEngine $view, private dppService $dppService)
    {
    }

    public function dppProfile()
    {



        echo $this->view->render(
            "/dpp/dpp.php",
            []
        );
    }

    public function addProcurement(){
        $this->dppService->addProcurement($_POST);
        redirectTo($_SERVER['HTTP_REFERER']);
    }
}
