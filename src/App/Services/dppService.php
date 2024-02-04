<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;

class dppService
{
    public function __construct(private Database $db)
    {
    }

    public function addProcurement()
    {
        $procActivity = "Procurement of Echos";
        $procAmount = 23;

        $allDL = $this->db->query("SELECT * FROM users WHERE classification = 'EP'")->findAll();
        foreach ($allDL as $user) {
            $assignment = unserialize($user['section']);
            if (in_array("DPP", $assignment)) {
                $users[] = $user['id'];
            }
        }
        $serializedUsers = serialize($users);

        $instructions = "Process the Procurement of this activity amounting to {$procAmount} for the 1st Quarter of CY-2024";

        $this->db->query(
            "INSERT INTO work (subject,instructions,assigned_to,type,added_by,added_from,status)
        VALUES(:subject,:instructions,:assigned_to,:type,:added_by,:added_from,:status)",
            [
                'subject' => $procActivity,
                'instructions' => $instructions,
                'assigned_to' => $serializedUsers,
                'type' => "Procurement",
                'added_by' => $_SESSION['user']['id'],
                'added_from' => "DPP Section",
                'status' => "UNCOMPLIED"
            ]
        );

        $subWorkArray = [
            "UPR",
            "APP",
            "PPMP",
            "SAA",
            "RIS-NIS",
            "BOME and Scope of Works",
            "Pre Repair Inspection",
            "CFC",
            "RFQ",
            "Abstract",
            "Minutes of Meeting",
            "Philgeps result",
            "Purchase Order",
            "Obligation Request",
            "Certificate of Reasonableness of Price",
            "Notice To Proceed",
            "Notice of Delivery",
            "Delivery Receipt",
            "Invoice Receipt",
            "COA Inspection",
            "Inspection and Acceptance Report",
            "Post Repair Inspection",
            "MFO Inspection report",
            "Delivered Items Inspection report",
            "certificate of Acceptance",
            "RIS",
            "RSMI",
            "Disbursement Voucher",
            "ADA",
            "Receipt from Supplier"
        ];
        $workId = $this->db->query("SELECT id from work ORDER BY id DESC LIMIT 1")->find();

        foreach ($subWorkArray as $sub) {
            $this->db->query(
                "INSERT INTO sub_work (main_id,sub_subject,status) VALUES (:main_id,:sub_subject,:status)",
                [
                    'main_id' => $workId['id'],
                    'sub_subject' => $sub,
                    'status' => "UNCOMPLIED"
                ]
            );
        }
    }
}
