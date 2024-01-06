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


    public function viewall(){
        $allActivity = $this->spendingPlanService->viewAllActivity();
        $totalFirstAmount = $this->spendingPlanService->totalAmount;
        echo $this->view->render("/spendingPlan.php", ['allActivity' => $allActivity,'totalFirstAmount' => $totalFirstAmount]);
    }

}