<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\config\paths;
use App\Services\{HomeService, ProfileService};


class HomeController
{

    public function __construct(private TemplateEngine $view, private HomeService $HomeService, private ProfileService $profileService)
    {
    }

    public function home()
    {
        // * Reset the session playlist array
        $_SESSION['playlist'] = [];

        // * redirect users to karaoke page if they are not authorized to use this page
        if ($_SESSION['user']['authority'] === "karaoke") {
            redirectTo('/karaoke');
        }

        $allWorkQueue = $this->HomeService->allWorkQueue();
        $allTimeliness = $this->HomeService->timelinessNumbers();
        $active = $this->HomeService->activeWorkNumbers();
        $updatesToday = $this->HomeService->updatesToday();
        $users = $this->HomeService->allUsers();
        $recentlyAdded = $this->HomeService->RecentlyAdded();
        $recentlyComplied = $this->HomeService->recentlyComplied();
        $followUp = $this->HomeService->followUp();
        $deadline = $this->HomeService->deadline();
        $pending = $this->HomeService->pending();

        echo $this->view->render(
            "index.php",
            [
                'allWorkQueue' => $allWorkQueue,
                'users' => $users,
                'timeliness' => $allTimeliness,
                'active' => $active,
                'updatesToday' => $updatesToday,
                'recentlyAdded' => $recentlyAdded,
                'recentlyComplied' => $recentlyComplied,
                'followUp' => $followUp,
                'deadline' => $deadline,
                'pending' => $pending
            ]
        );
    }

    public function renderUserProfile(array $params)
    {
        // * Profile Panel
        $user = $this->profileService->getUserDetails($params['id']);
        $fullName = $this->profileService->userFullNameSN;
        $workCount = $this->profileService->checkWorkNumbers($params['id']);
        $addedWorkCount = $this->profileService->checkAddedWorkNumbers($params['id']);
        echo $this->view->render(
            "/profile/profile.php",
            [
                'user' => $user,
                'fullName' => $fullName,
                'addedWorkCount' => $addedWorkCount,
                'workCount' => $workCount,
                'viewedFrom' => "dashboard"
            ]
        );
    }
}
