<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\config\paths;
use App\Services\{TransactionService, musicPlaylist};


class HomeController
{

    public function __construct(private TemplateEngine $view, private TransactionService $transactionService)
    {
    }

    public function home()
    {
        $_SESSION['playlist'] = [];
        if ($_SESSION['user']['authority'] === "karaoke") {
            redirectTo('/karaoke');
        }

        $allWorkQueue = $this->transactionService->allWorkQueue();
        echo $this->view->render("index.php", ['allWorkQueue' => $allWorkQueue]);
    }
}
