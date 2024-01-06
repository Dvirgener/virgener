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

    public function viewAllActivity(): array{
        $this->allActivities = $this->db->query("SELECT * FROM table_of_activities")->findAll();
        $this->firstAmount = $this->totalFirst();
        $this->secondAmount = $this->secondAmount();
        $this->thirdAmount = $this->thirdAmount();
        $this->fourthAmount = $this->fourthAmount();
        $this->totalAmount = $this->firstAmount + $this->secondAmount + $this->thirdAmount + $this->fourthAmount;
        
        return $this->allActivities;


    }

    public function totalFirst(){
        $totalFirstAmount = 0;
        foreach($this->allActivities as $firstAmount){
            $totalFirstAmount = $totalFirstAmount + $firstAmount['first_amount'];
        }
        return $totalFirstAmount;
    }
    public function secondAmount(){
        $totalFirstAmount = 0;
        foreach($this->allActivities as $firstAmount){
            $totalFirstAmount = $totalFirstAmount + $firstAmount['second_amount'];
        }
        return $totalFirstAmount;
    }
    public function thirdAmount(){
        $totalFirstAmount = 0;
        foreach($this->allActivities as $firstAmount){
            $totalFirstAmount = $totalFirstAmount + $firstAmount['third_amount'];
        }
        return $totalFirstAmount;
    }
    public function fourthAmount(){
        $totalFirstAmount = 0;
        foreach($this->allActivities as $firstAmount){
            $totalFirstAmount = $totalFirstAmount + $firstAmount['fourth_amount'];
        }
        return $totalFirstAmount;
    }
}