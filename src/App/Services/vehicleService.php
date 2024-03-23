<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;
use Framework\Exceptions\ValidationException;
use App\config\paths;
use Dotenv\Store\File\Paths as FilePaths;

class vehicleService
{
    public string $userFullName;
    public string $userFullNameSN;

    public function __construct(private Database $db)
    {
    }

    public function addVehicle(array $formData)
    {
        $this->db->query(
            "INSERT INTO vehicles (
        article, 
        descriptions, 
        plate_number, 
        year_acquired, 
        engine_number,
        chassis_number,
        unit,
        veh_status,
        renewal_date) VALUES (
        :article,
        :descriptions,
        :plate_number,
        :year_acquired, 
        :engine_number,
        :chassis_number,
        :unit,
        :veh_status,
        :renewal_date)",
            [
                'article' => $formData['article'],
                'descriptions' => $formData['description'],
                'plate_number' => $formData['plateNumber'],
                'year_acquired' => $formData['dateAcquired'],
                'engine_number' => $formData['engineNumber'],
                'chassis_number' => $formData['chassisNumber'],
                'unit' => $formData['unit'],
                'veh_status' => "IN",
                'renewal_date' => $formData['dateRenew']
            ]
        );

        return $this->db->id();
    }

    public function getVehicles()
    {
        $allVehicles = $this->db->query("SELECT * FROM vehicles")->findAll();

        $returnArray = [];
        foreach ($allVehicles as $vehicle) {
            // * format date to be readable
            $date = date_create($vehicle['renewal_date']);
            $renewalDate = date_format($date, "d F Y");
            $returnArray[] = [
                'id' => $vehicle['id'],
                'descriptions' => $vehicle['descriptions'],
                'plate_number' => $vehicle['plate_number'],
                'veh_status' => $vehicle['veh_status'],
                'renewalDate' => $renewalDate,
            ];
        }

        return $returnArray;
    }

    public function getVehicleDetails(int $id)
    {


        $vehicle = $this->db->query("SELECT * FROM vehicles WHERE id = :id", ['id' => $id])->find();
        $formattedDates = $this->db->query("SELECT DATE_FORMAT(renewal_date, '%Y-%m-%d') as renewalDate, DATE_FORMAT(year_acquired, '%Y-%m-%d') as acquiredDate  FROM vehicles WHERE id = :id", ['id' => $id])->find();

        $vehicle['formattedYearAcquired'] = $formattedDates['acquiredDate'];
        $vehicle['formattedRenewalDate'] = $formattedDates['renewalDate'];


        $dateToday = date('Y-m-d');
        $dateRenewal = strtotime($vehicle['renewal_date']);
        $dateToday = strtotime($dateToday);
        $interval = $dateRenewal - $dateToday;
        $daysInterval = floor($interval / (60 * 60 * 24));
        $vehicle['forRenew'] = false;
        if ($daysInterval <= 60) {
            $vehicle['forRenew'] = true;
        }
        $vehicle['needWork'] = false;
        if ($vehicle['veh_status'] == "OUT" || $vehicle['veh_status'] == "BER") {
            $vehicle['needWork'] = true;
        }
        $vehicle['pictures'] = unserialize($vehicle['pictures']);
        $vehicle['cert_reg'] = unserialize($vehicle['cert_reg']);
        $vehicle['official_receipt'] = unserialize($vehicle['official_receipt']);
        $vehicle['insurance_policy'] = unserialize($vehicle['insurance_policy']);

        // * format date to be readable
        $dateAcquired = date_create($vehicle['year_acquired']);
        $vehicle['year_acquired'] = date_format($dateAcquired, "d F Y");

        // * format date to be readable
        $renewalDate = date_create($vehicle['renewal_date']);
        $vehicle['renewal_date'] = date_format($renewalDate, "d F Y");


        return $vehicle;
    }

    public function getVehicleWork(int $id)
    {
        $returnArray = [];
        $vehicleHistory = $this->db->query("SELECT * FROM vehicle_history WHERE veh_id = :id", ['id' => $id])->findAll();

        foreach ($vehicleHistory as $history) {
            $addedBy = $this->db->query("SELECT * FROM users WHERE id = :id", ['id' => $history['added_by']])->find();

            if ($history['work_id'] != NULL) {
                // pd($history);
                $vehQueue = $this->db->query("SELECT * FROM work WHERE id = :id", ['id' => $history['work_id']])->find();
                // dd($vehQueue);
                if ($vehQueue['status'] != 'COMPLIED') {
                    $status = "ON GOING";
                } else {
                    $status = "COMPLIED";
                }

                $returnArray[] =
                    [
                        'vehWork' => true,
                        'id' => $vehQueue['id'],
                        'subject' => $history['remarks'],
                        'addedBy' => $addedBy['actual_rank'] . " " . $addedBy['last_name'] . " PAF",
                        'date' => $history['created_at'],
                        'status' => $status
                    ];
                continue;
            }

            $returnArray[] =
                [
                    'vehWork' => false,
                    'id' => $history['id'],
                    'subject' => $history['remarks'],
                    'addedBy' => $addedBy['actual_rank'] . " " . $addedBy['last_name'] . " PAF",
                    'date' => $history['created_at']
                ];
        }

        return $returnArray;
    }

    public function updateVehicleStatus(array $formData)
    {
        $this->db->query(
            "UPDATE vehicles SET veh_status = :veh_status, remarks = :remarks WHERE id = :id",
            [
                'veh_status' => $formData['vehStatus'],
                'remarks' => $formData['vehicleRemarks'],
                'id' => $formData['vehicleId']
            ]
        );

        switch ($formData['vehStatus']) {
            case 'IN':
                $historyRemarks = "The vehicle has been rendered operational";
                break;

            case 'OUT':
            case 'BER':
                $historyRemarks = "The vehicle has been rendered " . $formData['vehStatus'] . " due to " . $formData['vehicleRemarks'];
                break;
        }

        $this->db->query(
            "INSERT INTO vehicle_history (veh_id, remarks, added_by) VALUES (:id,:remarks,:added_by)",
            [
                'id' => $formData['vehicleId'],
                'remarks' => $historyRemarks,
                'added_by' => $_SESSION['user']['id']
            ]
        );
    }

    public function updateVehicleDetails(array $formData)
    {
        $this->db->query(
            "UPDATE vehicles SET
        unit = :unit,
        article = :article,
        descriptions = :descriptions,
        plate_number = :plate_number,
        engine_number = :engine_number,
        chassis_number = :chassis_number,
        year_acquired = :year_acquired,
        renewal_date = :renewal_date WHERE id = :id",
            [
                'unit' => $formData['unit'],
                'article' => $formData['article'],
                'descriptions' => $formData['description'],
                'plate_number' => $formData['plateNumber'],
                'engine_number' => $formData['engineNumber'],
                'chassis_number' => $formData['chassisNumber'],
                'year_acquired' => $formData['dateAcquired'],
                'renewal_date' => $formData['dateRenew'],
                'id' => $formData['id']
            ]
        );
    }

    public function deleteVehicle(int $id)
    {
        $fileArray = [];
        $vehicleFiles = $this->db->query("SELECT pictures, cert_reg, official_receipt, insurance_policy FROM vehicles WHERE id = :id", ['id' => $id])->find();
        $pictures = unserialize($vehicleFiles['pictures']);
        $cr = unserialize($vehicleFiles['cert_reg']);
        $or = unserialize($vehicleFiles['official_receipt']);
        $insurance = unserialize($vehicleFiles['insurance_policy']);
        array_push($fileArray, ...$pictures);
        array_push($fileArray, ...$cr);
        array_push($fileArray, ...$or);
        array_push($fileArray, ...$insurance);
        $this->db->query("DELETE FROM vehicles WHERE id = :id", ['id' => $id]);
        return $fileArray;
    }

    public function addVehicleWork(array $formData)
    {
        $assigned = serialize($formData['addto']);
        $formattedDate = "{$formData['addworktargetdate']}) 00:00:00";
        $this->db->query(
            "INSERT INTO work (subject, instructions, assigned_to, type, added_by, added_from, status, date_target, veh_id) 
                    VALUES (:subject, :instructions, :assigned_to, :type, :added_by, :added_from, :status, :date_target, :veh_id)",
            [
                'subject' => $formData['subject'],
                'instructions' => $formData['addworkintremarks'],
                'assigned_to' => $assigned,
                'type' => $formData['addworktype'],
                'added_by' => $_SESSION['user']['id'],
                'added_from' => "Vehicles",
                'status' => "UNCOMPLIED",
                'date_target' => $formattedDate,
                'veh_id' => $formData['id']
            ]
        );

        // * Function to get the id of the work added
        $workId = $this->db->id();
        if (isset($formData['sub'])) {
            foreach ($formData['sub'] as $subWork) {
                $this->db->query(
                    "INSERT INTO sub_work (main_id, sub_subject, status) VALUES (:main_id, :sub_subject,:status)",
                    [
                        'main_id' => $workId,
                        'sub_subject' => $subWork,
                        'status' => "UNCOMPLIED"
                    ]
                );
            }
        }

        $this->db->query(
            "INSERT INTO vehicle_history (veh_id, work_id, remarks, added_by) VALUES (:id, :work_id, :remarks, :added_by)",
            [
                'id' => $formData['id'],
                'work_id' => $workId,
                'remarks' => $formData['subject'],
                'added_by' => $_SESSION['user']['id']
            ]
        );


        return $workId;
    }

    public function renewVehicle(array $formData)
    {
        $vehicle = $this->db->query("SELECT * FROM vehicles WHERE id = :id", ['id' => $formData['id']])->find();
        $assigned = serialize($formData['addto']);
        $formattedDate = "{$vehicle['renewal_date']}) 00:00:00";
        $subject = "Renewal of insurance and registration for {$vehicle['descriptions']} ({$vehicle['plate_number']})";
        $instructions = "Please renew the insurance and registration of the vehicle in a timely manner";
        $subWork = [
            "Quotation from GSIS",
            "Quotation from LTO",
            "OBR and DV for GSIS",
            "OBR and DV for LTO",
            "Acquire Cheque",
            "Payment of Insurance"
        ];

        $this->db->query(
            "INSERT INTO work (subject, instructions, assigned_to, type, added_by, added_from, status, date_target, veh_id) 
                    VALUES (:subject, :instructions, :assigned_to, :type, :added_by, :added_from, :status, :date_target, :veh_id)",
            [
                'subject' => $subject,
                'instructions' => $instructions,
                'assigned_to' => $assigned,
                'type' => "Compliance",
                'added_by' => $_SESSION['user']['id'],
                'added_from' => "Vehicles",
                'status' => "UNCOMPLIED",
                'date_target' => $formattedDate,
                'veh_id' => $formData['id']
            ]
        );

        // * Function to get the id of the work added
        $workId = $this->db->id();

        foreach ($subWork as $sub) {
            $this->db->query(
                "INSERT INTO sub_work (main_id, sub_subject, status) VALUES (:main_id, :sub_subject,:status)",
                [
                    'main_id' => $workId,
                    'sub_subject' => $sub,
                    'status' => "UNCOMPLIED"
                ]
            );
        }

        $this->db->query(
            "INSERT INTO vehicle_history (veh_id, work_id, remarks, added_by) VALUES (:id, :work_id, :remarks, :added_by)",
            [
                'id' => $formData['id'],
                'work_id' => $workId,
                'remarks' => $subject,
                'added_by' => $_SESSION['user']['id']
            ]
        );

        return $workId;
    }
}
