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
        // * Profile Panel
        $user = $this->profileService->getUserDetails($_SESSION['user']['id']);
        $fullName = $this->profileService->userFullNameSN;
        $workCount = $this->profileService->checkWorkNumbers($_SESSION['user']['id']);
        $addedWorkCount = $this->profileService->checkAddedWorkNumbers($_SESSION['user']['id']);

        // * Work Panel
        $directedWork = $this->profileService->getDirectedWork($_SESSION['user']['id'], "UNCOMPLIED");
        $sectionWork = [];
        $addedWork = $this->profileService->getAddedWork($_SESSION['user']['id']);

        // * Add Work Modal
        $juniors = $this->profileService->fetchAllJuniors($_SESSION['user']['serial_number'], $_SESSION['user']['number_rank']);

        echo $this->view->render(
            "/profile/profile.php",
            [
                'user' => $user,
                'fullName' => $fullName,
                'juniors' => $juniors,
                'directedWork' => $directedWork,
                'sectionWork' => $sectionWork,
                'addedWork' => $addedWork,
                'addedWorkCount' => $addedWorkCount,
                'workCount' => $workCount
            ]
        );
    }

    public function viewWork()
    {
        // * Profile Panel
        $user = $this->profileService->getUserDetails($_SESSION['user']['id']);
        $fullName = $this->profileService->userFullNameSN;
        $workCount = $this->profileService->checkWorkNumbers($_SESSION['user']['id']);
        $addedWorkCount = $this->profileService->checkAddedWorkNumbers($_SESSION['user']['id']);

        // * Add Work Modal
        $juniors = $this->profileService->fetchAllJuniors($_SESSION['user']['serial_number'], $_SESSION['user']['number_rank']);

        // * View One Work
        $workArray = $this->profileService->workDetails($_GET['id']);

        if (empty($workArray['sub_work'])) {
            $workArray['sub_work'] = [];
        }

        echo $this->view->render(
            "/profile/workcue.php",
            [
                'user' => $user,
                'fullName' => $fullName,
                'workCount' => $workCount,
                'addedWorkCount' => $addedWorkCount,
                'workDetails' => $workArray['work'],
                'subWorkDetails' => $workArray['sub_work'],
                'juniors' => $juniors


            ]
        );
    }

    public function viewAddedWork()
    {
        // * Profile Panel
        $user = $this->profileService->getUserDetails($_SESSION['user']['id']);
        $fullName = $this->profileService->userFullNameSN;
        $workCount = $this->profileService->checkWorkNumbers($_SESSION['user']['id']);
        $addedWorkCount = $this->profileService->checkAddedWorkNumbers($_SESSION['user']['id']);

        // * Add Work Modal
        $juniors = $this->profileService->fetchAllJuniors($_SESSION['user']['serial_number'], $_SESSION['user']['number_rank']);

        // * View One Work
        $workArray = $this->profileService->workDetails($_GET['id']);

        if (empty($workArray['sub_work'])) {
            $workArray['sub_work'] = [];
        }

        echo $this->view->render(
            "/profile/added.php",
            [
                'user' => $user,
                'fullName' => $fullName,
                'workCount' => $workCount,
                'addedWorkCount' => $addedWorkCount,
                'workDetails' => $workArray['work'],
                'subWorkDetails' => $workArray['sub_work'],
                'juniors' => $juniors


            ]
        );
    }

    public function renderProfPic(array $params)
    {
        $this->profileService->readProfPic($params);
    }

    public function renderFile(array $params)
    {
        $this->profileService->readFile($params);
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

    public function addwork()
    {
        $this->profileService->addWork($_POST, $_FILES);
        redirectTo("/profile");
    }

    public function editWork()
    {
        // * Edit Work Modal
        $juniors = $this->profileService->fetchAllJuniors($_SESSION['user']['serial_number'], $_SESSION['user']['number_rank'], $_GET['id']);
        $workDetails = $this->profileService->editWork($_GET['id']);
        echo $this->view->render("/profile/editwork.php", ['editWorkDetails' => $workDetails, 'juniors' => $juniors]);
    }

    public function saveEditWork()
    {
        $this->profileService->saveEditWork($_POST, $_FILES);
        redirectTo($_SERVER['HTTP_REFERER']);
    }

    public function deleteWork()
    {
        echo $this->view->render("/profile/deletework.php", ['id' => $_GET['id']]);
    }

    public function confirmDeleteWork()
    {
        $this->profileService->deleteWork($_POST['idToDelete']);
        redirectTo("/profile");
    }

    public function viewFile()
    {
        echo $this->view->render("/profile/viewfile.php", ['file' => $_GET['file']]);
    }

    public function addSubWork()
    {
        $this->profileService->addSubWork($_POST);
        redirectTo($_SERVER['HTTP_REFERER']);
    }

    public function editSubWork()
    {
        // * Edit Sub Work Modal

        $subWorkDetails = $this->profileService->editSubWork($_GET['id']);
        echo $this->view->render(
            "/profile/editsubwork.php",
            [
                'subWorkDetails' => $subWorkDetails['subDetails'],
                'subAssigned' => $subWorkDetails['subAssigned']
            ]
        );
    }

    public function saveEditSubWork()
    {
        $this->profileService->saveEditSubWork($_POST);
        redirectTo($_SERVER['HTTP_REFERER']);
    }

    public function deleteSubWork()
    {
        echo $this->view->render("/profile/deletesubwork.php", ['id' => $_GET['id']]);
    }

    public function confirmDeleteSubWork()
    {

        $this->profileService->deleteSubWork($_POST['idToDelete']);
        redirectTo($_SERVER['HTTP_REFERER']);
    }

    public function updateWork()
    {
        $this->profileService->updateWork($_POST, $_FILES);
        redirectTo($_SERVER['HTTP_REFERER']);
    }

    public function updateSubWork()
    {
        $this->profileService->updateSubWork($_POST, $_FILES);
        redirectTo($_SERVER['HTTP_REFERER']);
    }

    public function complySubWork()
    {
        $this->profileService->complySubWork($_POST, $_FILES);
        redirectTo($_SERVER['HTTP_REFERER']);
    }

    public function complyWork()
    {
        $this->profileService->complyWork($_POST, $_FILES);
        redirectTo('/profile');
    }

    public function workHistory()
    {
        // * Profile Panel
        $user = $this->profileService->getUserDetails($_SESSION['user']['id']);
        $fullName = $this->profileService->userFullNameSN;
        $workCount = $this->profileService->checkWorkNumbers($_SESSION['user']['id']);
        $addedWorkCount = $this->profileService->checkAddedWorkNumbers($_SESSION['user']['id']);
        $juniors = $this->profileService->fetchAllJuniors($_SESSION['user']['serial_number'], $_SESSION['user']['number_rank']);

        // * Work Panel
        $directedWork = $this->profileService->getDirectedWork($_SESSION['user']['id'], "COMPLIED");
        $sectionWork = [];
        $addedWork = $this->profileService->getAddedWork($_SESSION['user']['id']);


        echo $this->view->render(
            "/profile/workhistory.php",
            [
                'user' => $user,
                'fullName' => $fullName,
                'juniors' => $juniors,
                'directedWork' => $directedWork,
                'sectionWork' => $sectionWork,
                'addedWork' => $addedWork,
                'addedWorkCount' => $addedWorkCount,
                'workCount' => $workCount
            ]
        );
    }

    public function viewWorkHistory()
    {
        // * Profile Panel
        $user = $this->profileService->getUserDetails($_SESSION['user']['id']);
        $fullName = $this->profileService->userFullNameSN;
        $workCount = $this->profileService->checkWorkNumbers($_SESSION['user']['id']);
        $addedWorkCount = $this->profileService->checkAddedWorkNumbers($_SESSION['user']['id']);

        // * Add Work Modal
        $juniors = $this->profileService->fetchAllJuniors($_SESSION['user']['serial_number'], $_SESSION['user']['number_rank']);

        // * View One Work
        $workArray = $this->profileService->workDetails($_GET['id']);

        if (empty($workArray['sub_work'])) {
            $workArray['sub_work'] = [];
        }

        echo $this->view->render(
            "/profile/workcueHistory.php",
            [
                'user' => $user,
                'fullName' => $fullName,
                'workCount' => $workCount,
                'addedWorkCount' => $addedWorkCount,
                'workDetails' => $workArray['work'],
                'subWorkDetails' => $workArray['sub_work'],
                'juniors' => $juniors


            ]
        );
    }

    public function officeHistory()
    {

        echo $this->view->render(
            "/profile/officeWorkHistory.php",
            []
        );
    }

    public function confirmWork()
    {
        echo $this->view->render("/profile/confirmWork.php", ['id' => $_GET['id']]);
    }

    public function confirmCompliance()
    {
        $this->profileService->confirmCompliance($_GET['id']);
        redirectTo("/profile");
    }

    public function returnCompliance()
    {
        $this->profileService->returnCompliance($_GET['id']);
        redirectTo("/profile");
    }
}
