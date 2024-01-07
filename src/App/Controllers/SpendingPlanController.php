<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\config\paths;
use App\Services\{TransactionService, SpendingPlanService, musicPlaylist};


class SpendingPlanController
{

    public function __construct(private TemplateEngine $view, private TransactionService $transactionService, private SpendingPlanService $spendingPlanService)
    {
    }


    public function viewall()
    {
        $allActivity = $this->spendingPlanService->viewAllActivity();

        $totalFirstAmount = $this->spendingPlanService->totalAmount;
        echo $this->view->render("/financial/spendingPlan.php", ['allActivity' => $allActivity, 'totalFirstAmount' => $totalFirstAmount]);
    }

    public function searchToAddSaa()
    {
        $dataa = $this->spendingPlanService->addSaaSearch($_GET);
        $quarter = $_GET['quarter'];

        echo $this->view->render("/financial/addSaaSearchResult.php", ['result' => $dataa, 'quarter' => $quarter]);
    }

    public function addSaa()
    {
        dd($_POST);
    }
}
