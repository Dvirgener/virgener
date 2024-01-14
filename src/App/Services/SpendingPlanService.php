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

    // * View all activities in the db function
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
    // * Get the total of first Qtr Activities
    public function totalFirst()
    {
        $totalFirstAmount = 0;
        foreach ($this->allActivities as $firstAmount) {
            $totalFirstAmount = $totalFirstAmount + $firstAmount['first_amount'];
        }
        return $totalFirstAmount;
    }
    // * Get the total of second Qtr Activities
    public function secondAmount()
    {
        $totalFirstAmount = 0;
        foreach ($this->allActivities as $firstAmount) {
            $totalFirstAmount = $totalFirstAmount + $firstAmount['second_amount'];
        }
        return $totalFirstAmount;
    }
    // * Get the total of third Qtr Activities
    public function thirdAmount()
    {
        $totalFirstAmount = 0;
        foreach ($this->allActivities as $firstAmount) {
            $totalFirstAmount = $totalFirstAmount + $firstAmount['third_amount'];
        }
        return $totalFirstAmount;
    }
    // * Get the total of fourth Qtr Activities
    public function fourthAmount()
    {
        $totalFirstAmount = 0;
        foreach ($this->allActivities as $firstAmount) {
            $totalFirstAmount = $totalFirstAmount + $firstAmount['fourth_amount'];
        }
        return $totalFirstAmount;
    }


    // * ================================================ Add SAA Section ===============================================================
    // * this pertains to the search bar for adding Saa
    public function addSaaSearch(array $formData)
    {
        switch ($formData['quarter']) {
            case 1:
                $quarter = "first_amount";
                $quarterSaa = "first_saa";
                $quarterResult = "First Quarter";
                break;
            case 2:
                $quarter = "second_amount";
                $quarterSaa = "second_saa";
                $quarterResult = "Second Quarter";

                break;
            case 3:
                $quarter = "third_amount";
                $quarterSaa = "third_saa";
                $quarterResult = "Third Quarter";

                break;
            case 4:
                $quarter = "fourth_amount";
                $quarterSaa = "fourth_saa";
                $quarterResult = "Fourth Quarter";

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

    // * this pertains to the add saa formdata with file 
    public function addsaa(array $formData, ?array $fileData)
    {
        if (!$fileData || $fileData['error'] !== UPLOAD_ERR_OK) {
            throw new ValidationException([
                'saaFileError' => ["Failed to upload File!"]
            ]);
        }

        $maxFileSizeMB = 30 * 1024 * 1024;

        if ($fileData['size'] > $maxFileSizeMB) {
            throw new ValidationException(['saaFileError' => ["File upload is too large!"]]);
        }

        $originalFileName = $fileData['name'];

        if (!preg_match('/^[A-Za-z0-9\s._-]+$/', $originalFileName)) {
            throw new ValidationException(['saaFileError' => ["Invalid Filename!"]]);
        }

        $clientMimeType = $fileData['type'];
        $allowedMimeTypes = ['application/pdf'];

        if (!in_array($clientMimeType, $allowedMimeTypes)) {
            throw new ValidationException(['saaFileError' => ["Invalid File Type!"]]);
        }

        $fileExtension = pathinfo($fileData['name'], PATHINFO_EXTENSION);
        $newFileName = bin2hex(random_bytes(16)) . "." . $fileExtension;
        $uploadpath = paths::STORAGE_UPLOADS_SAA . "/" . $newFileName;

        if (!move_uploaded_file($fileData['tmp_name'], $uploadpath)) {
            throw new ValidationException(['saaFileError' => ["Failed to upload file!"]]);
        }

        $formattedDate = "{$formData['saa_date']}) 00:00:00";

        switch ($formData['quarter']) {
            case 1:
                $actualQuarterToSave = "1st Quarter";
                break;
            case 2:
                $actualQuarterToSave = "2nd Quarter";
                break;
            case 3:
                $actualQuarterToSave = "3rd Quarter";
                break;
            case 4:
                $actualQuarterToSave = "4th Quarter";
                break;
        }

        $saaAmount = [];
        foreach ($formData['activitiesId'] as $activity) {
            $actDetails = $this->db->query("SELECT * FROM table_of_activities WHERE id = :id", ['id' => $activity])->find();
            switch ($formData['quarter']) {
                case 1:
                    $this->db->query("UPDATE table_of_activities SET first_saa = :first_saa WHERE id = :id", ['first_saa' => 1, 'id' => $activity]);
                    $saaAmount[] = $actDetails['first_amount'];
                    break;
                case 2:
                    $this->db->query("UPDATE table_of_activities SET second_saa = :second_saa WHERE id = :id", ['first_saa' => 1, 'id' => $activity]);
                    $saaAmount[] = $actDetails['second_amount'];
                    break;
                case 3:
                    $this->db->query("UPDATE table_of_activities SET third_saa = :third_saa WHERE id = :id", ['third_saa' => 1, 'id' => $activity]);
                    $saaAmount[] = $actDetails['third_amount'];
                    break;
                case 4:
                    $this->db->query("UPDATE table_of_activities SET fourth_saa = :fourth_saa WHERE id = :id", ['fourth_saa' => 1, 'id' => $activity]);
                    $saaAmount[] = $actDetails['fourth_amount'];
                    break;
            }
        }
        $saaAmountSum = array_sum($saaAmount);

        $ids = serialize($formData['activitiesId']);
        $this->db->query(
            "INSERT INTO saa_table (
                saa_desc,
                saa_quarter,
                saa_number,
                saa_acct_code,
                saa_amount,
                saa_date, 
                saa_remarks,
                saa_file,
                saa_origFile,
                saa_type,
                activity_ids, 
                added_by) 
        VALUES (:saa_desc,
                :saa_quarter,
                :saa_number,
                :saa_acct_code,
                :saa_amount,
                :saa_date,
                :saa_remarks,
                :saa_file,
                :saa_origFile,
                :saa_type,
                :activity_ids, 
                :added_by)",
            [
                'saa_desc' => $formData['act_desc'],
                'saa_quarter' => $actualQuarterToSave,
                'saa_number' => $formData['saa_nr'],
                'saa_acct_code' => $formData['acct_code'],
                'saa_amount' => $saaAmountSum,
                'saa_date' => $formattedDate,
                'saa_remarks' => $formData['saa_remarks'],
                'saa_file' => $newFileName,
                'saa_origFile' => $fileData['name'],
                'saa_type' => $fileData['type'],
                'activity_ids' => $ids,
                'added_by' => $_SESSION['user']['id']
            ]
        );
    }
    // * ================================================ Add SAA Section ===============================================================


    // * ================================================ View SAA Section ==============================================================

    public function viewSaaTable()
    {
        return $this->db->query("SELECT * FROM saa_table")->findAll();
    }

    public function viewSaaId($id)
    {
        return $this->db->query("SELECT * FROM saa_table WHERE id = :id", ['id' => $id])->find();
    }

    public function viewSaaActivities(string $ids, string $quarter)
    {
        $activityIds = unserialize($ids);
        $activities = [];


        foreach ($activityIds as $activity) {
            $activities[] = $this->db->query("SELECT * FROM table_of_activities WHERE id =:id", ['id' => $activity])->find();
        }
        return $activities;
    }

    public function deleteSaa($id)
    {
        // dd($id);
        $saa = $this->db->query("SELECT * FROM saa_table WHERE id = :id", ['id' => $id])->find();

        $saaActivities = unserialize($saa['activity_ids']);

        switch ($saa['saa_quarter']) {
            case "1st Quarter":
                $act_quarter = "first_saa";
                break;
            case "2nd Quarter":
                $act_quarter = "second_saa";
                break;
            case "3rd Quarter":
                $act_quarter = "third_saa";
                break;
            case "4th Quarter":
                $act_quarter = "fourth_saa";
                break;
        }

        foreach ($saaActivities as $activity) {
            $this->db->query("UPDATE table_of_activities SET {$act_quarter} = 0 WHERE id = :id", ['id' => $activity]);
        }
        $this->db->query("DELETE FROM saa_table WHERE id= :id", ['id' => $id]);
    }


    // * ================================================ View SAA Section ==============================================================

}
