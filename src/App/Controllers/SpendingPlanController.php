<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\config\paths;
use App\Services\{TransactionService, SpendingPlanService, ValidatorService};


class SpendingPlanController
{

    public function __construct(
        private TemplateEngine $view,
        private TransactionService $transactionService,
        private SpendingPlanService $spendingPlanService,
        private ValidatorService $validatorService
    ) {
    }


    public function viewall()
    {
        $allActivity = $this->spendingPlanService->viewAllActivity();
        $allSaa = $this->spendingPlanService->viewSaaTable();

        $totalFirstAmount = $this->spendingPlanService->totalAmount;
        echo $this->view->render(
            "/financial/spendingPlan.php",
            [
                'allActivity' => $allActivity,
                'totalFirstAmount' => $totalFirstAmount,
                'allSaa' => $allSaa
            ]
        );
    }

    public function searchToAddSaa()
    {
        $this->validatorService->validateSearchActivityForm($_GET);
        $dataa = $this->spendingPlanService->addSaaSearch($_GET);
        $quarter = $_GET['quarter'];
        $accountCode = $_GET['acct_code'];

        echo $this->view->render("/financial/addSaaSearchResult.php", ['result' => $dataa, 'quarter' => $quarter, 'acct_code' => $accountCode]);
    }

    public function addSaa()
    {
        $this->spendingPlanService->addSaa($_POST, $_FILES['saa_pdf']);
        redirectTo('/spendingplan');
    }

    public function viewSaa()
    {
        $saaDetails = $this->spendingPlanService->viewSaaId($_GET['id']);
        $saaActivities = $this->spendingPlanService->viewSaaActivities($saaDetails['activity_ids'], $saaDetails['saa_quarter']);
        switch ($saaDetails['saa_quarter']) {
            case "1st Quarter":
                $act_quarter = "first_amount";
                break;
            case "2nd Quarter":
                $act_quarter = "second_amount";
                break;
            case "3rd Quarter":
                $act_quarter = "third_amount";
                break;
            case "4th Quarter":
                $act_quarter = "fourth_amount";
                break;
        }
        echo $this->view->render("/financial/saaView.php", [
            'saaDetails' => $saaDetails,
            'saaActivities' => $saaActivities,
            'act_quarter' => $act_quarter
        ]);
    }

    public function deleteSaa()
    {
        $this->spendingPlanService->deleteSaa($_GET['id']);
    }
}
