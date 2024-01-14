<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\config\paths;
use App\Services\{TransactionService, ProfileService};


class ProfileController
{

    public function __construct(private TemplateEngine $view, private ProfileService $profileService)
    {
    }

    public function viewProfile()
    {
        $user = $this->profileService->getUserDetails($_SESSION['user']['id']);
        $fullName = $this->profileService->userFullNameSN;

        if ($user['section'] != "") {
            $section = unserialize($user['section']);
        }
        $finalSec = [];
        foreach ($section as $sec) {
            if ($sec === "DPP") {
                $finalSec[$sec] = "Financial and Physical Obligation";
                continue;
            }
            if ($sec === "DBFEE") {
                $finalSec[$sec] = "Equipment and Vehicles";
                continue;
            }
            if ($sec === "DMS") {
                $finalSec[$sec] = "POL Products and ICIE";
                continue;
            }
            if ($sec === "DMA") {
                $finalSec[$sec] = "Munition and Armaments Management";
                continue;
            }
            if ($sec === "DAMM") {
                $finalSec[$sec] = "AeroDrome Ground Equipment Services";
                continue;
            }
            if ($sec === "ADMIN") {
                $finalSec[$sec] = "Administrative Services";
                continue;
            }
        }
        echo $this->view->render("/profile/profile.php", ['user' => $user, 'fullName' => $fullName, 'finalSec' => $finalSec]);
    }

    public function viewWork()
    {
        $user = $this->profileService->getUserDetails($_SESSION['user']['id']);
        $fullName = $this->profileService->userFullNameSN;

        if ($user['section'] != "") {
            $section = unserialize($user['section']);
        }
        $finalSec = [];
        foreach ($section as $sec) {
            if ($sec === "DPP") {
                $finalSec[$sec] = "Financial and Physical Obligation";
                continue;
            }
            if ($sec === "DBFEE") {
                $finalSec[$sec] = "Equipment and Vehicles";
                continue;
            }
            if ($sec === "DMS") {
                $finalSec[$sec] = "POL Products and ICIE";
                continue;
            }
            if ($sec === "DMA") {
                $finalSec[$sec] = "Munition and Armaments Management";
                continue;
            }
            if ($sec === "DAMM") {
                $finalSec[$sec] = "AeroDrome Ground Equipment Services";
                continue;
            }
            if ($sec === "ADMIN") {
                $finalSec[$sec] = "Administrative Services";
                continue;
            }
        }
        echo $this->view->render("/profile/workcue.php", ['user' => $user, 'fullName' => $fullName, 'finalSec' => $finalSec]);
    }

    public function userSettings()
    {
        $user = $this->profileService->getUserDetails($_SESSION['user']['id']);
        $section = [];
        if ($user['section'] != "") {
            $section = unserialize($user['section']);
        }
        echo $this->view->render("/profile/settings.php", ['user' => $user, 'section' => $section]);
    }

    public function updateUser()
    {
        $this->profileService->updateUserProfilePic($_FILES);
        $this->profileService->updateUserDetail($_POST);
        redirectTo('/settings');
    }

    public function renderProfPic(array $params)
    {
        $this->profileService->readProfPic($params);
    }
}
