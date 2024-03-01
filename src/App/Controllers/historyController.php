<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\config\paths;
use App\Services\{ValidatorService, ProfileService, FileService, historyService};


class historyController
{

    public function __construct(private ValidatorService $ValidatorService, private TemplateEngine $view, private ProfileService $profileService, private FileService $fileService, private historyService $historyService)
    {
    }


    // * Render content for Edit Work modal
    public function workHistory()
    {
        $compliedWork = $this->historyService->getCompliedWork();
        echo $this->view->render("/history/history.php", ['viewedFrom' => "history", 'compliedWork' => $compliedWork]);
    }
}
