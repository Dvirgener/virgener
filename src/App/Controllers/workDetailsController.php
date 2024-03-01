<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\config\paths;
use App\Services\{TransactionService, workDetailsService, FileService};


class workDetailsController
{

    public function __construct(private TemplateEngine $view, private workDetailsService $workDetailsService, private FileService $fileService)
    {
    }

    // * Function for viewing work details
    public function viewWorkDetails(array $params)
    {
        // * Get Work Details
        $workArray = $this->workDetailsService->workDetails($params['id']);
        echo $this->view->render(
            "/profile/workdetail.php",
            [
                'workDetails' => $workArray['work'],
                'subWorkDetails' => $workArray['sub_work'],
                'viewedFrom' => $params['viewedFrom'],
                'viewedOn' => "work queue"
            ]
        );
    }

    // * Function for viewing added work details
    public function viewAddedWorkDetails(array $params)
    {
        // * Get Work Details
        $workArray = $this->workDetailsService->workDetails($params['id']);

        echo $this->view->render(
            "/profile/workdetail.php",
            [
                'workDetails' => $workArray['work'],
                'subWorkDetails' => $workArray['sub_work'],
                'viewedFrom' => $params['viewedFrom'],
                'viewedOn' => "added queue"


            ]
        );
    }

    public function viewUpdates(array $params)
    {
        $updates = $this->workDetailsService->getUpdates($params['id'], $params['sub']);
        $workArray = $this->workDetailsService->workDetails($params['id']);
        echo $this->view->render(
            "/profile/updates.php",
            [
                'updates' => $updates,
                'viewedFrom' => $params['view'],
                'addedBy' => $workArray['work']['added_by'],
                'viewedOn' => "added queue"
            ]
        );
    }

    public function viewAddedUpdates(array $params)
    {
        $updates = $this->workDetailsService->getUpdates($params['id'], $params['sub']);
        $workArray = $this->workDetailsService->workDetails($params['id']);
        echo $this->view->render(
            "/profile/addedUpdates.php",
            [
                'updates' => $updates,
                'viewedFrom' => $params['view'],
                'addedBy' => $workArray['work']['added_by'],
                'viewedOn' => "added queue"
            ]
        );
    }

    // * Render content for Edit Work modal
    public function renderEditWorkModal(array $params)
    {
        $juniors = $this->workDetailsService->fetchAllJuniors($_SESSION['user']['serial_number'], $_SESSION['user']['number_rank'], $params['id']);
        $workDetails = $this->workDetailsService->editWork($params['id']);
        echo $this->view->render("/profile/modalRender/editwork.php", ['editWorkDetails' => $workDetails, 'juniors' => $juniors]);
    }

    // * Save edited work
    public function saveEditedWork()
    {
        $this->workDetailsService->saveEditedWork($_POST);
        $this->fileService->upload("editWork", $_POST['id'], $_FILES);
    }

    // * Delete work
    public function deleteWork()
    {
        $filesToDelete = $this->workDetailsService->deleteWork((int) $_POST['idToDelete']);
        $this->fileService->deleteFile($filesToDelete);
        redirectTo("/profile");
    }

    // * Edit Sub Work Queue
    public function editSubWork(array $params)
    {
        $subWorkDetails = $this->workDetailsService->editSubWork($params['id']);
        echo $this->view->render(
            "/profile/modalRender/editsubwork.php",
            [
                'subWorkDetails' => $subWorkDetails['subDetails'],
                'subAssigned' => $subWorkDetails['subAssigned']
            ]
        );
    }

    public function saveEditSubWork()
    {
        $this->workDetailsService->saveEditSubWork($_POST);
    }

    public function renderDeleteSubWorkModel(array $params)
    {
        $mainWorkId = $this->workDetailsService->getWorkId($params['id']);
        echo $this->view->render("/profile/modalRender/deletesubwork.php", ['main_id' => $mainWorkId, 'id' => $params['id']]);
    }

    public function deleteSubWork()
    {
        $filesToDelete = $this->workDetailsService->deleteSubWork((int) $_POST['idToDelete']);
        $this->fileService->deleteFile($filesToDelete);
    }

    public function addSubWork()
    {
        $this->workDetailsService->addSubWork($_POST);
    }

    public function deleteUpdate()
    {
        $filesToDelete = $this->workDetailsService->deleteUpdate($_POST);
        $this->fileService->deleteFile($filesToDelete);
    }

    public function updateWork()
    {
        $updateId = $this->workDetailsService->updateWork($_POST);
        $this->fileService->upload("updateWork", $updateId, $_FILES);
    }

    public function complyWork()
    {
        $complianceArray = $this->workDetailsService->complyWork($_POST);
        $this->fileService->upload("complyWork", $complianceArray['id'], $_FILES);
    }

    public function approveCompliance()
    {
        $this->workDetailsService->confirmCompliance($_GET['id']);
    }

    public function returnCompliance()
    {
        $this->workDetailsService->returnCompliance($_GET['id']);
    }
}
