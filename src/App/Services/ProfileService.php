<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;
use Framework\Exceptions\ValidationException;
use App\config\paths;
use Dotenv\Store\File\Paths as FilePaths;

class ProfileService
{
    public string $userFullName;
    public string $userFullNameSN;

    public function __construct(private Database $db)
    {
    }


    // * Getting user details from DB for use of Side Profile
    public function getUserDetails($id): array
    {
        $userDetails = $this->db->query("SELECT * FROM users WHERE id = :id", ['id' => $id])->find();
        $this->userFullName = $userDetails['actual_rank'] . " " . $userDetails['first_name'] . " " . $userDetails['last_name'] . " PAF";
        $this->userFullNameSN = $userDetails['actual_rank'] . " " . $userDetails['first_name'] . " " . $userDetails['last_name'] . " " . $userDetails['serial_number'] . " PAF";
        if ($userDetails['section'] != "") {
            $section = unserialize($userDetails['section']);
        } else if ($userDetails['position'] == "OIC" || $userDetails['position'] == "AOIC") {
            $section = [];
        }
        $finalSec = [];
        foreach ($section as $sec) {
            if ($sec === "DPP") {
                $finalSec[$sec] = "Financial and Physical Obligation";
                continue;
            }
            if ($sec === "DBFEE") {
                $finalSec[$sec] = "Equipment and Vehicles";
                continue;
            }
            if ($sec === "DMS") {
                $finalSec[$sec] = "POL Products and ICIE";
                continue;
            }
            if ($sec === "DMA") {
                $finalSec[$sec] = "Munition and Armaments Management";
                continue;
            }
            if ($sec === "DAMM") {
                $finalSec[$sec] = "AeroDrome Ground Equipment Services";
                continue;
            }
            if ($sec === "ADMIN") {
                $finalSec[$sec] = "Administrative Services";
                continue;
            }
        }
        $userDetails['finalsec'] = $finalSec;
        return $userDetails;
    }

    // * Fetch all Juniors of the Logged-in user in the DB for add Work Queue Modal
    public function fetchAllJuniors(int $serialNumber, int $rank): array
    {
        $allusers = $this->db->query("SELECT * FROM users")->findAll();
        $juniors = [];
        foreach ($allusers as $user) {
            if ($user['number_rank'] <= $rank && $user['serial_number'] >= $serialNumber && $user['classification'] == "EP") {
                if (isset($assignedUsers)) {
                    $user['check'] = "";
                    if (in_array($user['id'], $assignedUsers)) {
                        $user['check'] = "checked";
                    }
                }
                $juniors[] = $user;
                continue;
            }
            if ($user['number_rank'] < $rank) {
                if (isset($assignedUsers)) {
                    $user['check'] = "";
                    if (in_array($user['id'], $assignedUsers)) {
                        $user['check'] = "checked";
                    }
                }
                $juniors[] = $user;
            }
        }
        $keys = array_column($juniors, 'serial_number');
        array_multisort($keys, SORT_ASC, $juniors);
        return $juniors;
    }

    // * This is for rendering the profile pic of the user
    public function readProfPic(array $params)
    {
        $filePath = paths::STORAGE_UPLOADS_PROFPIC . '/' . $params['profilePic'];
        if (!file_exists($filePath)) {
            redirectTo('/');
        }
        header("content-disposition: inline;filename={acwdcwa}");
        header("content-type: {.jpg,.jpeg,.png}");
        readfile($filePath);
    }

    // * This is for the add work function based on the input provided on the add work modal
    public function addWork(array $formData)
    {
        $assigned = serialize($formData['addto']);
        $formattedDate = "{$formData['addworktargetdate']}) 00:00:00";
        $this->db->query(
            "INSERT INTO work (subject, instructions, assigned_to, type, added_by, added_from, status, date_target) 
                    VALUES (:subject, :instructions, :assigned_to, :type, :added_by, :added_from, :status, :date_target)",
            [
                'subject' => $formData['subject'],
                'instructions' => $formData['addworkintremarks'],
                'assigned_to' => $assigned,
                'type' => $formData['addworktype'],
                'added_by' => $_SESSION['user']['id'],
                'added_from' => $formData['addedfrom'],
                'status' => "UNCOMPLIED",
                'date_target' => $formattedDate
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
        return $workId;
    }

    // * This is for work numbers of the user
    public function checkWorkNumbers($id): array
    {
        $id = (string) $id;
        $currentWork = 0;
        $unupdatedWork = 0;
        $endangeredWork = 0;
        $allwork = $this->db->query("SELECT * FROM work WHERE status = 'UNCOMPLIED'")->findAll();
        foreach ($allwork as $work) {
            $assigned = unserialize($work['assigned_to']);
            if (in_array($id, $assigned)) {
                $currentWork += 1;
                $res = checkUpdate($work['updated_at']);
                if ($res) {
                    $unupdatedWork += 1;
                }
                if ($work['date_target'] != "0000-00-00") {
                    $res = checkDeadline($work['date_target']);
                    if ($res) {
                        $endangeredWork += 1;
                    }
                }
            }
        }

        $workCount['active'] = $currentWork;
        $workCount['unupdated'] = $unupdatedWork;
        $workCount['danger'] = $endangeredWork;
        return $workCount;
    }

    public function checkPending($id)
    {
        $allwork = $this->db->query("SELECT * FROM work WHERE status = 'PENDING'")->findAll();
        $pending = 0;
        foreach ($allwork as $work) {
            if ($id == $work['added_by']) {
                $pending += 1;
            }
        }
        return $pending;
    }

    // * This is for the added work numbers of the user
    public function checkAddedWorkNumbers($id): array
    {
        $id = (string) $id;
        $currentWork = 0;
        $unupdatedWork = 0;
        $endangeredWork = 0;
        $allwork = $this->db->query("SELECT * FROM work WHERE status = 'UNCOMPLIED'")->findAll();
        foreach ($allwork as $work) {
            if ($id == $work['added_by']) {
                $currentWork += 1;
                $res = checkUpdate($work['updated_at']);
                if ($res) {
                    $unupdatedWork += 1;
                }
                if ($work['date_target'] != "0000-00-00") {
                    $res = checkDeadline($work['date_target']);
                    if ($res) {
                        $endangeredWork += 1;
                    }
                }
            }
        }

        $workCount['active'] = $currentWork;
        $workCount['unupdated'] = $unupdatedWork;
        $workCount['danger'] = $endangeredWork;
        return $workCount;
    }

    // * This is for reading file from folder
    public function readFile($params)
    {
        // dd($params);
        $filePath = paths::STORAGE_UPLOADS_FILEREFERENCE . '/' . $params['file'];
        if (!file_exists($filePath)) {
            redirectTo('/');
        }
        header("content-disposition: inline;filename={acwdcwa}");
        header("content-type: {.jpg,.jpeg,.png}");
        readfile($filePath);
    }

    // * This is for fetching all complied files that are assigned to the ID
    public function getCompliedNumbers($id)
    {
        $noTD = 0;
        $early = 0;
        $onTime = 0;
        $late = 0;
        $allComplied = $this->db->query("SELECT * FROM work WHERE status = 'COMPLIED'")->findAll();
        foreach ($allComplied as $work) {
            $workOwners = unserialize($work['assigned_to']);
            if (in_array($id, $workOwners)) {
                switch ($work['timeliness']) {
                    case 'No TD':
                        $noTD += 1;
                        break;
                    case 'Early':
                        $early += 1;
                        break;
                    case 'On Time':
                        $onTime += 1;
                        break;
                    case 'Late':
                        $late += 1;
                        break;
                }
            }
        }
        return ['noTD' => $noTD, 'early' => $early, 'onTime' => $onTime, 'late' => $late];
    }
}
