<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\config\paths;
use App\Services\{TransactionService, workQueueService};


class WorkQueueController
{

    public function __construct(private TemplateEngine $view, private workQueueService $workQueueService)
    {
    }

    public function viewWorkList(array $params)
    {
        // * Work Panel
        $directedWork = $this->workQueueService->getDirectedWork($params['id'], "UNCOMPLIED");
        $addedWork = $this->workQueueService->getAddedWork($params['id']);

        echo $this->view->render(
            "/profile/worklist.php",
            [
                'directedWork' => $directedWork,
                'addedWork' => $addedWork,
                'viewedFrom' => $params['viewedFrom']
            ]
        );
    }
}
