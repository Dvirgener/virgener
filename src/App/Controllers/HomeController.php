<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\config\paths;
use App\Services\{HomeService, ProfileService, UserService};


class HomeController
{

    public function __construct(private TemplateEngine $view, private HomeService $HomeService, private ProfileService $profileService, private UserService $userService)
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

        if ($_SESSION['user']['position'] === "Personnel") {
            redirectTo('/profile');
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
        // $subordinates = $this->userService->subordinateOfUser((int) $_SESSION['user']['id']);
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
        $pending = $this->profileService->checkPending($_SESSION['user']['id']);
        $workTimeliness = $this->profileService->getCompliedNumbers($params['id']);
        echo $this->view->render(
            "/profile/profile.php",
            [
                'user' => $user,
                'fullName' => $fullName,
                'addedWorkCount' => $addedWorkCount,
                'workCount' => $workCount,
                'viewedFrom' => "dashboard",
                'pending' => $pending,
                'workTimeliness' => $workTimeliness
            ]
        );
    }

    public function special()
    {
        $nums = [3, 14, 4, 8, 12, 1, 11, 6, 78];
        $target = 23;


        function twoSum($nums, $target)
        {
            $index1 = 0; // index of the first element on the first foreach
            $theSameAsNum = [];
            foreach ($nums as $num) {

                $index2 = 0; // index of the first element inside second the foreach
                foreach ($nums as $nr) {
                    if ($index1 == $index2) {
                        continue;
                    }
                    $res = $num + $nr;
                    if ($res == $target) {
                        $theSameAsNum[] = $index2;
                        $theSameAsNum[] = $index1;
                        return $theSameAsNum;
                    }
                    $index2 += 1;
                }
                $index1 += 1;
            }
        }
        pd(twoSum($nums, $target));
    }
}
