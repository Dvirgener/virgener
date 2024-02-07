<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\config\paths;
use App\Services\{TransactionService, settingsService};


class settingsController
{

    public function __construct(private TemplateEngine $view, private settingsService $settingsService)
    {
    }

    public function userSettings()
    {
        $user = $this->settingsService->getUserDetails($_SESSION['user']['id']);
        $section = [];
        if ($user['section'] != "") {
            $section = unserialize($user['section']);
        }
        echo $this->view->render("/profile/settings.php", ['user' => $user, 'section' => $section]);
    }

    public function updateUser()
    {
        $this->settingsService->updateUserProfilePic($_FILES);
        $this->settingsService->updateUserDetail($_POST);
        redirectTo('/settings');
    }
}
