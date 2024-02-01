<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\config\paths;
use App\Services\{HomeService};


class HomeController
{

    public function __construct(private TemplateEngine $view, private HomeService $HomeService)
    {
    }

    public function home()
    {
        $_SESSION['playlist'] = [];
        if ($_SESSION['user']['authority'] === "karaoke") {
            redirectTo('/karaoke');
        }

        $allWorkQueue = $this->HomeService->allWorkQueue();
        $allTimeliness = $this->HomeService->timelinessNumbers();
        $active = $this->HomeService->activeWorkNumbers();
        $updatesToday = $this->HomeService->updatesToday();
        $users = $this->HomeService->allUsers();
        $recentlyAdded = $this->HomeService->RecentlyAdded();
        echo $this->view->render(
            "index.php",
            [
                'allWorkQueue' => $allWorkQueue,
                'users' => $users,
                'timeliness' => $allTimeliness,
                'active' => $active,
                'updatesToday' => $updatesToday,
                'recentlyAdded' => $recentlyAdded
            ]
        );
    }
}
