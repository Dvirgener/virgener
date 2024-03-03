<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\config\paths;
use App\Services\{ValidatorService, ProfileService, FileService, vehicleService, UserService};


class vehicleController
{

    public function __construct(private ValidatorService $ValidatorService, private TemplateEngine $view, private ProfileService $profileService, private FileService $fileService, private vehicleService $vehicleService, private UserService $userService)
    {
    }

    public function renderVehiclePage()
    {
        $allVehicles = $this->vehicleService->getVehicles();
        echo $this->view->render("/dbfee/vehicles.php", ['allVehicles' => $allVehicles]);
    }

    public function addVehicle()
    {
        $vehicleId = $this->vehicleService->addVehicle($_POST);
        $this->fileService->vehicleUpload("pictures", $vehicleId, $_FILES['pictures']);
        $this->fileService->vehicleUpload("certOfReg", $vehicleId, $_FILES['certOfReg']);
        $this->fileService->vehicleUpload("officialReceipt", $vehicleId, $_FILES['officialReceipt']);
        $this->fileService->vehicleUpload("insurance", $vehicleId, $_FILES['insurance']);
    }

    public function vehicleDetails(array $params)
    {
        $users = $this->userService->usersInSection("DBFEE");
        $vehicle = $this->vehicleService->getVehicleDetails((int) $params['id']);
        $vehicleWork = $this->vehicleService->getVehicleWork((int) $params['id']);
        echo $this->view->render("/dbfee/vehicledetails.php", ['vehicle' => $vehicle, 'users' => $users, 'vehicleWorks' => $vehicleWork]);
    }

    public function updateVehicleStatus()
    {
        $this->vehicleService->updateVehicleStatus($_POST);
    }

    public function updateVehicleDetails()
    {
        $this->vehicleService->updateVehicleDetails($_POST);
        $this->fileService->vehicleUpload("updatePictures", $_POST['id'], $_FILES['pictures']);
        $this->fileService->vehicleUpload("updateCertOfReg", $_POST['id'], $_FILES['certOfReg']);
        $this->fileService->vehicleUpload("updateOfficialReceipt", $_POST['id'], $_FILES['officialReceipt']);
        $this->fileService->vehicleUpload("updateInsurance", $_POST['id'], $_FILES['insurance']);
    }

    public function deleteVehicle()
    {
        $filesArray = $this->vehicleService->deleteVehicle((int) $_GET['id']);
        $this->fileService->deleteExistingFiles($filesArray);
    }

    public function addVehicleWork()
    {
        $id = $this->vehicleService->addVehicleWork($_POST);
        $this->fileService->upload("addWork", $id, $_FILES['workfiles']);
        redirectTo("/section/vehicle");
    }

    public function renewVehicle()
    {
        $id = $this->vehicleService->renewVehicle($_POST);
        redirectTo("/section/vehicle");
    }
}
