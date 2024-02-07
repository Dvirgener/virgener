<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\config\paths;
use App\Services\{TransactionService, workDetailsService};


class workDetailsController
{

    public function __construct(private TemplateEngine $view, private workDetailsService $workDetailsService)
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
                'viewedFrom' => $params['viewedFrom']
            ]
        );
    }

    // * Function for viewing added work details
    public function viewAddedWorkDetails(array $params)
    {
        // * Get Work Details
        $workArray = $this->workDetailsService->workDetails($params['id']);
        echo $this->view->render(
            "/profile/workaddeddetail.php",
            [
                'workDetails' => $workArray['work'],
                'subWorkDetails' => $workArray['sub_work'],
                'viewedFrom' => $params['viewedFrom']
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
        $this->workDetailsService->saveEditedWork($_POST, $_FILES);
    }

    // * Delete work
    public function deleteWork()
    {
        $this->workDetailsService->deleteWork($_POST['idToDelete']);
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
        $this->workDetailsService->deleteSubWork($_POST['idToDelete']);
    }

    public function addSubWork()
    {
        $this->workDetailsService->addSubWork($_POST);
    }

    public function deleteUpdate()
    {
        $this->workDetailsService->deleteUpdate($_POST);
    }

    public function updateWork()
    {
        $this->workDetailsService->updateWork($_POST, $_FILES);
    }

    public function updateSubWork()
    {
        $this->workDetailsService->updateSubWork($_POST, $_FILES);
    }

    public function complySubWork()
    {
        $this->workDetailsService->complySubWork($_POST, $_FILES);
    }

    public function complyWork()
    {
        $this->workDetailsService->complyWork($_POST, $_FILES);
        redirectTo('/profile');
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
