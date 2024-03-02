<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\config\paths;
use App\Services\{ValidatorService, ProfileService, FileService, vehicleService};


class vehicleController
{

    public function __construct(private ValidatorService $ValidatorService, private TemplateEngine $view, private ProfileService $profileService, private FileService $fileService, private vehicleService $vehicleService)
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
        echo $this->view->render("/dbfee/vehicledetails.php", ['allVehicles' => 'awc']);
    }
}
