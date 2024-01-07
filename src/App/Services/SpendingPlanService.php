<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;
use Framework\Exceptions\ValidationException;

class SpendingPlanService
{
    private array $allActivities;
    private float $firstAmount;
    private float $secondAmount;
    private float $thirdAmount;
    private float $fourthAmount;
    public float $totalAmount;

    public function __construct(private Database $db)
    {
    }

    public function viewAllActivity(): array
    {
        $this->allActivities = $this->db->query("SELECT * FROM table_of_activities")->findAll();
        $this->firstAmount = $this->totalFirst();
        $this->secondAmount = $this->secondAmount();
        $this->thirdAmount = $this->thirdAmount();
        $this->fourthAmount = $this->fourthAmount();
        $this->totalAmount = $this->firstAmount + $this->secondAmount + $this->thirdAmount + $this->fourthAmount;

        return $this->allActivities;
    }

    public function totalFirst()
    {
        $totalFirstAmount = 0;
        foreach ($this->allActivities as $firstAmount) {
            $totalFirstAmount = $totalFirstAmount + $firstAmount['first_amount'];
        }
        return $totalFirstAmount;
    }
    public function secondAmount()
    {
        $totalFirstAmount = 0;
        foreach ($this->allActivities as $firstAmount) {
            $totalFirstAmount = $totalFirstAmount + $firstAmount['second_amount'];
        }
        return $totalFirstAmount;
    }
    public function thirdAmount()
    {
        $totalFirstAmount = 0;
        foreach ($this->allActivities as $firstAmount) {
            $totalFirstAmount = $totalFirstAmount + $firstAmount['third_amount'];
        }
        return $totalFirstAmount;
    }
    public function fourthAmount()
    {
        $totalFirstAmount = 0;
        foreach ($this->allActivities as $firstAmount) {
            $totalFirstAmount = $totalFirstAmount + $firstAmount['fourth_amount'];
        }
        return $totalFirstAmount;
    }

    public function addSaaSearch($formData)
    {
        switch ($formData['quarter']) {
            case 1:
                $quarter = "first_amount";
                break;
            case 2:
                $quarter = "second_amount";
                break;
            case 3:
                $quarter = "third_amount";
                break;
            case 4:
                $quarter = "fourth_amount";
                break;
        }

        return $this->db->query(
            "SELECT * FROM table_of_activities WHERE 
        acct_code = :acct_code AND reviewing_staff = :rev_staff AND {$quarter} != 0.00",
            [
                'acct_code' => $formData['acct_code'],
                'rev_staff' => $formData['reviewing_staff']
            ]
        )->findall();
    }

    public function addsaa($formData)
    {
        $ids = serialize($formData['activitiesId']);
        $this->db->query(
            "INSERT INTO saa_table (saa_number, activity_ids, added_by) 
        VALUES (:saa_number,:activity_ids, :added_by)",
            [
                'saa_number' => $formData['saa_nr'],
                'activity_ids' => $ids,
                'added_by' => $_SESSION['user']
            ]
        );
    }
}
