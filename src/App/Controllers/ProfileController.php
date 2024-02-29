<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\config\paths;
use App\Services\{ValidatorService, ProfileService, FileService};


class ProfileController
{

    public function __construct(private ValidatorService $ValidatorService, private TemplateEngine $view, private ProfileService $profileService, private FileService $fileService)
    {
    }

    public function backTo()
    {
        redirectTo($_SERVER['HTTP_REFERER']);
    }

    // * This function is for viewing the side profile of the User
    public function viewProfile()
    {
        // * Profile Panel
        $user = $this->profileService->getUserDetails($_SESSION['user']['id']);
        $fullName = $this->profileService->userFullNameSN;
        $workCount = $this->profileService->checkWorkNumbers($_SESSION['user']['id']);
        $pending = $this->profileService->checkPending($_SESSION['user']['id']);
        $addedWorkCount = $this->profileService->checkAddedWorkNumbers($_SESSION['user']['id']);
        // * Add Work Modal
        $juniors = $this->profileService->fetchAllJuniors($_SESSION['user']['serial_number'], $_SESSION['user']['number_rank']);
        echo $this->view->render(
            "/profile/profile.php",
            [
                'user' => $user,
                'fullName' => $fullName,
                'juniors' => $juniors,
                'addedWorkCount' => $addedWorkCount,
                'workCount' => $workCount,
                'pending' => $pending,
                'viewedFrom' => "profile"
            ]
        );
    }

    // * This Function is for rendering profile pic
    public function renderProfPic(array $params)
    {
        $this->profileService->readProfPic($params);
    }

    // * This function is for adding Work Queue
    public function addwork()
    {
        $id = $this->profileService->addWork($_POST);
        $this->fileService->upload("addWork", $id, $_FILES);
        redirectTo("/profile");
    }

    // * Function to view File
    public function viewFile()
    {
        $fileData = $this->fileService->getFile($_GET['file']);
        echo $this->view->render("/profile/modalRender/viewfile.php", ['file' => $fileData]);
    }

    // * function to render file
    public function renderFile(array $params)
    {
        $this->fileService->read($params);
    }
}
