<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;
use Framework\Exceptions\ValidationException;

use App\config\paths;
use Dotenv\Store\File\Paths as FilePaths;

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
                $quarterSaa = "first_saa";
                break;
            case 2:
                $quarter = "second_amount";
                $quarterSaa = "second_saa";
                break;
            case 3:
                $quarter = "third_amount";
                $quarterSaa = "third_saa";
                break;
            case 4:
                $quarter = "fourth_amount";
                $quarterSaa = "fourth_saa";
                break;
        }

        return $this->db->query(
            "SELECT * FROM table_of_activities WHERE 
        acct_code = :acct_code AND reviewing_staff = :rev_staff AND {$quarter} != 0.00 AND {$quarterSaa} = 0",
            [
                'acct_code' => $formData['acct_code'],
                'rev_staff' => $formData['reviewing_staff']
            ]
        )->findall();
    }

    public function addsaa(array $formData, $fileData)
    {

        if (!$fileData || $fileData['error'] !== UPLOAD_ERR_OK){
            throw new ValidationException([
                'receipt' => ["Failed to upload File!"]
            ]);
        }

        $maxFileSizeMB = 30 * 1024 * 1024;

        if ($fileData['size'] > $maxFileSizeMB){
            throw new ValidationException(['receipt' => ["File upload is too large!"]]);
            dd("size error");
        }

        $originalFileName = $fileData['name'];

        if (!preg_match('/^[A-Za-z0-9\s._-]+$/',$originalFileName)){
            throw new ValidationException(['receipt' => ["Invalid Filename!"]]);
            dd("name error");

        }

        $clientMimeType = $fileData['type'];
        $allowedMimeTypes = ['image/jpeg','image/png','application/pdf'];

        if (!in_array($clientMimeType,$allowedMimeTypes)){
            throw new ValidationException(['receipt' => ["Invalid File Type!"]]);
            dd("type error");

        }

        $fileExtension = pathinfo($fileData['name'], PATHINFO_EXTENSION);
        $newFileName = bin2hex(random_bytes(16)). ".". $fileExtension;
        $uploadpath = paths::STORAGE_UPLOADS_SAA . "/" . $newFileName;

        if(!move_uploaded_file($fileData['tmp_name'],$uploadpath)){
            throw new ValidationException(['receipt' => ["Failed to upload file!"]]);
            dd("upload error");

        }
        

        $ids = serialize($formData['activitiesId']);
        $this->db->query(
            "INSERT INTO saa_table (
                saa_number, 
                saa_file,
                saa_origFile,
                saa_type,
                activity_ids, 
                added_by) 
        VALUES (:saa_number,:saa_file,:saa_origFile,:saa_type,:activity_ids, :added_by)",
            [
                'saa_number' => $formData['saa_nr'],
                'saa_file' => $newFileName,
                'saa_origFile' => $fileData['name'],
                'saa_type' =>$fileData['type'],
                'activity_ids' => $ids,
                'added_by' => $_SESSION['user']
            ]
        );

        foreach ($formData['activitiesId'] as $activity){
            $saaId = $this->db->query("SELECT * FROM saa_table WHERE saa_number = :saa_number",['saa_number' => $formData['saa_nr']])->find();
            switch($formData['quarter']){
                case 1:
                    $this->db->query("UPDATE table_of_activities SET first_saa = :first_saa WHERE id = :id",['first_saa' => $saaId['id'],'id' => $activity]);
                    break;
                case 2:
                    $this->db->query("UPDATE table_of_activities SET second_saa = :second_saa WHERE id = :id",['first_saa' => $saaId['id'],'id' => $activity]);
                    break;    
                case 3:
                    $this->db->query("UPDATE table_of_activities SET third_saa = :third_saa WHERE id = :id",['third_saa' => $saaId['id'],'id' => $activity]);
                    break; 
                case 4:
                    $this->db->query("UPDATE table_of_activities SET fourth_saa = :fourth_saa WHERE id = :id",['fourth_saa' => $saaId['id'],'id' => $activity]);
                    break;
            }              
        }
    }
}
