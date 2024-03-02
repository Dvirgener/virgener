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
}
