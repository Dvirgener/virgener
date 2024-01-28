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

    private function nameOfId($id)
    {
        $user = $this->db->query("SELECT * FROM users WHERE id = :id", ['id' => $id])->find();
        return $name = $user['actual_rank'] . " " . $user['last_name'] . " PAF";
    }

    public function getUserDetails($id)
    {
        $userDetails = $this->db->query("SELECT * FROM users WHERE id = :id", ['id' => $id])->find();

        $this->userFullName = $userDetails['actual_rank'] . " " . $userDetails['first_name'] . " " . $userDetails['last_name'] . " PAF";
        $this->userFullNameSN = $userDetails['actual_rank'] . " " . $userDetails['first_name'] . " " . $userDetails['last_name'] . " " . $userDetails['serial_number'] . " PAF";


        if ($userDetails['section'] != "") {
            $section = unserialize($userDetails['section']);
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

    public function updateUserProfilePic(?array $fileData)
    {
        // dd($fileData['profilePic']['name']);
        if ($fileData['profilePic']['name'] !== "") {
            $file = $fileData['profilePic'];
            if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
                throw new ValidationException([
                    'receipt' => ["Failed to upload File!"]
                ]);
            }

            $maxFileSizeMB = 10 * 1024 * 1024;

            if ($file['size'] > $maxFileSizeMB) {
                throw new ValidationException(['receipt' => ["File upload is too large!"]]);
            }

            $originalFileName = $file['name'];

            if (!preg_match('/^[A-Za-z0-9\s._-]+$/', $originalFileName)) {
                throw new ValidationException(['receipt' => ["Invalid Filename!"]]);
            }

            $clientMimeType = $file['type'];
            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/jpg'];

            if (!in_array($clientMimeType, $allowedMimeTypes)) {
                throw new ValidationException(['receipt' => ["Invalid File Type!"]]);
            }

            $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $newFileName = bin2hex(random_bytes(16)) . "." . $fileExtension;
            $uploadpath = paths::STORAGE_UPLOADS_PROFPIC . "/" . $newFileName;

            if (!move_uploaded_file($file['tmp_name'], $uploadpath)) {
                throw new ValidationException(['receipt' => ["Failed to upload file!"]]);
            }

            $this->db->query("UPDATE users SET picture = :picture WHERE id = :id", ['picture' => $newFileName, 'id' => $_SESSION['user']['id']]);
        }
    }

    public function updateUserDetail($form)
    {
        switch ($form['rank']) {
            case 1:
                $actual_rank = "AM";
                break;
            case 2:
                $actual_rank = "A2C";
                break;
            case 3:
                $actual_rank = "A1C";
                break;
            case 4:
                $actual_rank = "SGT";
                break;
            case 5:
                $actual_rank = "SSG";
                break;
            case 6:
                $actual_rank = "TSG";
                break;
            case 7:
                $actual_rank = "MSG";
                break;
            case 8:
                $actual_rank = "2LT";
                break;
            case 9:
                $actual_rank = "1LT";
                break;
            case 10:
                $actual_rank = "CPT";
                break;
            case 11:
                $actual_rank = "MAJ";
                break;
            case 12:
                $actual_rank = "LTC";
                break;
        }

        if (isset($form['section'])) {
            $section = serialize($form['section']);
        } else {
            $section = "";
        }

        if ($form['password'] != "") {

            if ($form['password'] !== $form['confirmPassword']) {
                redirectTo('/profile');
            }
            $password = password_hash($form['password'], PASSWORD_BCRYPT, ['cost => 12']);

            $this->db->query(
                "UPDATE users SET 
                first_name = :firstName,
                last_name = :lastName,
                actual_rank = :actualRank,
                number_rank = :numberRank,
                serial_number = :serialNumber,
                position = :position,
                section = :section,
                email = :email,
                password = :password WHERE id = :id",
                [
                    'firstName' => $form['firstName'],
                    'lastName' => $form['lastName'],
                    'actualRank' => $actual_rank,
                    'numberRank' => $form['rank'],
                    'serialNumber' => $form['serialNumber'],
                    'position' => $form['position'],
                    'section' => $section,
                    'email' => $form['email'],
                    'password' => $password,
                    'id' => $_SESSION['user']['id']
                ]
            );
        } else {
            $this->db->query(
                "UPDATE users SET 
                first_name = :firstName,
                last_name = :lastName,
                actual_rank = :actualRank,
                number_rank = :numberRank,
                serial_number = :serialNumber,
                position = :position,
                section = :section,
                email = :email WHERE id = :id",
                [
                    'firstName' => $form['firstName'],
                    'lastName' => $form['lastName'],
                    'actualRank' => $actual_rank,
                    'numberRank' => $form['rank'],
                    'serialNumber' => $form['serialNumber'],
                    'position' => $form['position'],
                    'section' => $section,
                    'email' => $form['email'],
                    'id' => $_SESSION['user']['id']
                ]
            );
        }
    }

    public function fetchAllUsers()
    {
        return $this->db->query("SELECT * FROM users")->findAll();
    }

    public function fetchAllJuniors($serialNumber, $rank, $workId = NULL): array
    {
        if ($workId != NULL) {
            $assignedUsers = $this->db->query("SELECT assigned_to FROM work WHERE id = :id", ['id' => $workId])->find();
            $assignedUsers = unserialize($assignedUsers['assigned_to']);
        }

        $allusers = $this->db->query("SELECT * FROM users")->findAll();
        $juniors = [];
        foreach ($allusers as $user) {
            if ($user['serial_number'] <= $serialNumber && $user['serial_number'] != 0) {
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
        array_multisort($keys, SORT_DESC, $juniors);
        return $juniors;
    }

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

    public function readFile($params)
    {
        $filePath = paths::STORAGE_UPLOADS_WORKREF . '/' . $params['file'];

        if (!file_exists($filePath)) {
            redirectTo('/');
        }

        header("content-disposition: inline;filename={acwdcwa}");
        header("content-type: {.jpg,.jpeg,.png}");
        readfile($filePath);
    }

    public function addWork(array $formData, ?array $fileData)
    {
        $filetosave = "";
        if ($fileData['workfiles']['name'][0] != "") {
            $names = $_FILES['workfiles']['name'];
            $tmp_name = $_FILES['workfiles']['tmp_name'];
            $files_array = array_combine($tmp_name, $names);
            $filenamearray = array();
            foreach ($files_array as $tmp_folder => $file_name) {
                $fileExtension = pathinfo($file_name, PATHINFO_EXTENSION);
                $newFileName = bin2hex(random_bytes(16)) . "." . $fileExtension;
                $uploadpath = paths::STORAGE_UPLOADS_WORKREF . "/" . $newFileName;

                if (!move_uploaded_file($tmp_folder, $uploadpath)) {
                    throw new ValidationException(['receipt' => ["Failed to upload file!"]]);
                }
                array_push($filenamearray, $newFileName);
            }
            $filetosave = serialize($filenamearray);
        }

        $assigned = serialize($formData['addto']);
        $formattedDate = "{$formData['addworktargetdate']}) 00:00:00";

        $this->db->query(
            "INSERT INTO work (subject, instructions, assigned_to, type, added_by, added_from, status, date_target, files) 
                    VALUES (:subject, :instructions, :assigned_to, :type, :added_by, :added_from, :status, :date_target, :files)",
            [
                'subject' => $formData['subject'],
                'instructions' => $formData['addworkintremarks'],
                'assigned_to' => $assigned,
                'type' => $formData['addworktype'],
                'added_by' => $_SESSION['user']['id'],
                'added_from' => $formData['addedfrom'],
                'status' => "UNCOMPLIED",
                'date_target' => $formattedDate,
                'files' => $filetosave
            ]
        );

        $workId = $this->db->query("SELECT id from work ORDER BY id DESC LIMIT 1")->find();

        if (isset($formData['sub'])) {
            foreach ($formData['sub'] as $subWork) {

                $this->db->query(
                    "INSERT INTO sub_work (main_id, sub_subject, status) VALUES (:main_id, :sub_subject,:status)",
                    [
                        'main_id' => $workId['id'],
                        'sub_subject' => $subWork,
                        'status' => "UNCOMPLIED"
                    ]
                );
            }
        }
    }

    public function saveEditWork(array $formData, ?array $fileData)
    {

        $assigned = serialize($formData['addto']);
        $formattedDate = "{$formData['addworktargetdate']}) 00:00:00";

        if ($fileData['workfiles']['name'][0] != "") {
            $names = $_FILES['workfiles']['name'];
            $tmp_name = $_FILES['workfiles']['tmp_name'];
            $files_array = array_combine($tmp_name, $names);
            $filenamearray = array();
            foreach ($files_array as $tmp_folder => $file_name) {

                $fileExtension = pathinfo($file_name, PATHINFO_EXTENSION);
                $newFileName = bin2hex(random_bytes(16)) . "." . $fileExtension;
                $uploadpath = paths::STORAGE_UPLOADS_WORKREF . "/" . $newFileName;
                if (!move_uploaded_file($tmp_folder, $uploadpath)) {
                    throw new ValidationException(['receipt' => ["Failed to upload file!"]]);
                }
                array_push($filenamearray, $newFileName);
            }
            $filetosave = serialize($filenamearray);

            $this->db->query(
                "UPDATE work SET subject = :subject, instructions = :instructions, assigned_to = :assigned_to, date_target = :date_target, files = :files WHERE id = :id",
                [
                    'subject' => $formData['subject'],
                    'instructions' => $formData['addworkintremarks'],
                    'assigned_to' => $assigned,
                    'date_target' => $formattedDate,
                    'files' => $filetosave,
                    'id' => $formData['id']

                ]
            );
        } else {
            $this->db->query(
                "UPDATE work SET subject = :subject, instructions = :instructions, assigned_to = :assigned_to, date_target = :date_target WHERE id = :id",
                [
                    'subject' => $formData['subject'],
                    'instructions' => $formData['addworkintremarks'],
                    'assigned_to' => $assigned,
                    'date_target' => $formattedDate,
                    'id' => $formData['id']
                ]

            );
        }
    }

    public function getDirectedWork($id, $status)
    {
        $id = (string) $id;
        $allwork = $this->db->query("SELECT * FROM work WHERE status = :status", ['status' => $status])->findAll();
        $myWork = [];
        foreach ($allwork as $work) {
            $assigned = unserialize($work['assigned_to']);
            if (in_array($id, $assigned)) {
                $work['style'] = "background-color:none; color:black";

                $dateadded = $work['updated_at'];
                $datetoday = date('Y-m-d');
                $dateadded = strtotime($dateadded);
                $datetoday = strtotime($datetoday);
                $interval = $datetoday - $dateadded;
                $daysinterval = floor($interval / (60 * 60 * 24));
                if ($daysinterval >= 1) {
                    $work['style'] = "background-color:orange; color:black";
                }

                if ($work['date_target'] != "0000-00-00") {
                    $dateadded = $work['date_target'];
                    $datetoday = date('Y-m-d');
                    $dateadded = strtotime($dateadded);
                    $datetoday = strtotime($datetoday);
                    $interval = $dateadded - $datetoday;
                    $daysinterval = floor($interval / (60 * 60 * 24));
                    if ($daysinterval <= 1) {
                        $work['style'] = "background-color:red; color:white";
                    }
                }
                if ($status == "COMPLIED") {
                    $compliedBy = $this->db->query("SELECT * FROM users WHERE id = :id", ['id' => $work['complied_by']])->find();
                    $work['complied_by'] = $compliedBy['actual_rank'] . " " . $compliedBy['last_name'] . " PAF";
                }
                $addedByName = $this->db->query("SELECT * FROM users WHERE id = :id", ['id' => $work['added_by']])->find();
                $work['added_by'] = $addedByName['actual_rank'] . " " . $addedByName['last_name'] . " PAF";


                $myWork[] = $work;
            }
        }
        return $myWork;
    }

    public function getAddedWork($id)
    {

        $id = (string) $id;
        $allwork = $this->db->query("SELECT * FROM work WHERE status = 'UNCOMPLIED' AND added_by = :id", ['id' => $id])->findAll();
        $myWork = [];
        foreach ($allwork as $work) {
            $assigned = unserialize($work['assigned_to']);
            $work['style'] = "background-color:none; color:black";
            $dateadded = $work['updated_at'];
            $datetoday = date('Y-m-d');
            $dateadded = strtotime($dateadded);
            $datetoday = strtotime($datetoday);
            $interval = $datetoday - $dateadded;
            $daysinterval = floor($interval / (60 * 60 * 24));
            if ($daysinterval >= 1) {
                $work['style'] = "background-color:orange; color:black";
            }

            if ($work['date_target'] != "0000-00-00") {
                $dateadded = $work['date_target'];
                $datetoday = date('Y-m-d');
                $dateadded = strtotime($dateadded);
                $datetoday = strtotime($datetoday);
                $interval = $dateadded - $datetoday;
                $daysinterval = floor($interval / (60 * 60 * 24));
                if ($daysinterval <= 1) {
                    $work['style'] = "background-color:red; color:white";
                }
            }
            $myWork[] = $work;
        }
        return $myWork;
    }

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

                $dateadded = $work['updated_at'];
                $datetoday = date('Y-m-d');
                $dateadded = strtotime($dateadded);
                $datetoday = strtotime($datetoday);
                $interval = $datetoday - $dateadded;
                $daysinterval = floor($interval / (60 * 60 * 24));
                if ($daysinterval >= 1) {
                    $unupdatedWork += 1;
                }

                if ($work['date_target'] != "0000-00-00") {
                    $dateadded = $work['date_target'];
                    $datetoday = date('Y-m-d');
                    $dateadded = strtotime($dateadded);
                    $datetoday = strtotime($datetoday);
                    $interval = $dateadded - $datetoday;
                    $daysinterval = floor($interval / (60 * 60 * 24));
                    if ($daysinterval <= 1) {
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

                $dateadded = $work['updated_at'];
                $datetoday = date('Y-m-d');
                $dateadded = strtotime($dateadded);
                $datetoday = strtotime($datetoday);
                $interval = $datetoday - $dateadded;
                $daysinterval = floor($interval / (60 * 60 * 24));
                if ($daysinterval >= 1) {
                    $unupdatedWork += 1;
                }

                if ($work['date_target'] != "0000-00-00") {
                    $dateadded = $work['date_target'];
                    $datetoday = date('Y-m-d');
                    $dateadded = strtotime($dateadded);
                    $datetoday = strtotime($datetoday);
                    $interval = $dateadded - $datetoday;
                    $daysinterval = floor($interval / (60 * 60 * 24));
                    if ($daysinterval <= 1) {
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

    public function workDetails($workId)
    {
        // * Select all work queue from DB with the ID variable
        $work = $this->db->query("SELECT * FROM work WHERE id = :id", ['id' => $workId])->find();

        // * unserialized assigned users and assign names to Ids
        $work['assigned_to'] = unserialize($work['assigned_to']);
        foreach ($work['assigned_to'] as $id) {
            $user = $this->db->query("SELECT * FROM users WHERE id = :id", ['id' => $id])->find();
            $name = $user['actual_rank'] . " " . $user['last_name'] . "" . " PAF";
            $work['detailedAssignee'][] = ['picture' => $user['picture'], 'name' => $name, 'id' => $user['id']];
        }

        // * Check if the work has files uploaded or not
        if (($work['files']) == "") {
            $work['files'] = [];
        } else {
            $work['files'] = unserialize($work['files']);
        }

        // * assign name to the work added
        $work['added_by_name'] = $this->nameOfId($work['added_by']);

        // * Array for the list of subwork with details
        $finalSubWorkList = [];

        // * Search the DB for all work updates on the work queue
        $workUpdates = $this->db->query("SELECT * FROM updates WHERE main_id = :main_id", ['main_id' => $workId])->findAll();
        // * array for detailed work updates
        $detailedWorkUpdates = [];

        // *Scan Each work updates for details
        foreach ($workUpdates as $workUpdate) {
            // * Assign name for the person who made the update
            $workUpdate['updated_by'] = $this->nameOfId($workUpdate['updated_by']);

            // * Check if it came from a sub work queue

            if ($workUpdate['sub_id'] != 0) {
                $subSubject = $this->db->query("SELECT sub_subject FROM sub_work WHERE id = :id", ['id' => $workUpdate['sub_id']])->find();
                $workUpdate['sub_id'] = $subSubject['sub_subject'];
            }

            // * Check if the update has a file uploaded
            if ($workUpdate['files'] == "") {
                $workUpdate['files'] = [];
            } else {
                $workUpdate['files'] = unserialize($workUpdate['files']);
            }
            // * Check if the update is a final update or what you call compliance remarks
            $workUpdate['complied'] = "";
            if ($workUpdate['final'] == "YES") {
                $workUpdate['complied'] = "Compliance Remarks!";
            }

            // * format date to be readable
            $date = date_create($workUpdate['created_at']);
            $workUpdate['created_at'] = date_format($date, "d F Y");


            // * add the work update to the array
            $detailedWorkUpdates[] = $workUpdate;
        }

        // * sort all the updates by Date
        $keys = array_column($detailedWorkUpdates, 'created_at');
        array_multisort($keys, SORT_ASC, $detailedWorkUpdates);

        // * assign the detailed work updates to the updates array
        $work['updates'] = $detailedWorkUpdates;

        // * Check for sub work of this Work Queue
        $sub_work = $this->db->query("SELECT * FROM sub_work WHERE main_id = :id", ['id' => $workId])->findall();

        // * Variable for subwork complied
        $work['subWorkComplied'] = true;
        $checkSubWorkComplied = [];

        // * scan each subwork created
        foreach ($sub_work as $subStatus) {

            // * Check if a sub work is already Complied.
            $subStatus['comp'] = ['bg' => "", 'compBut' => ""];
            if ($subStatus['status'] == "COMPLIED") {
                $subStatus['comp'] = ['bg' => ' OK!', 'compBut' => "disabled"];
            }

            //  * Check if sub work assignee is not empty
            if (!empty($subStatus['assigned_to'])) {
                $subAssigned = unserialize($subStatus['assigned_to']);
                $assignedName = [];

                // * variable for disabling / enabling comply button
                $authBut = "disabled";
                if (in_array($_SESSION['user']['id'], $subAssigned)) {
                    $authBut = "";
                }
                // * assign names for each assigned user
                foreach ($subAssigned as $id) {
                    $assignedName[] = $this->nameOfId($id);
                }
                $subStatus['assignedNames'] = $assignedName;
                $subStatus['authBut'] = $authBut;
                $finalSubWorkList[] = $subStatus;
            } else {
                $subStatus['authBut'] = "";
                $subStatus['assignedNames'] = [];
                $finalSubWorkList[] = $subStatus;
            }

            // * assign sub Work to an array
            $checkSubWorkComplied[] = $subStatus['status'];
        }

        // * Check if there's still a sub work with an UNCOMPLIED remark
        if (in_array("UNCOMPLIED", $checkSubWorkComplied)) {
            $work['subWorkComplied'] = false;
        }
        $sub_work = $finalSubWorkList;

        // * add work and sub work details to an array before you hit return
        $workdetails['work'] = $work;
        $workdetails['sub_work'] = $sub_work;
        return $workdetails;
    }

    public function editWork($id)
    {
        $workDetails = $this->db->query("SELECT *, DATE_FORMAT(date_target, '%Y-%m-%d') as formatted_date FROM work WHERE id = :id", ['id' => $id])->find();
        $workDetails['assigned_to'] = unserialize($workDetails['assigned_to']);
        return $workDetails;
    }

    public function deleteWork($id)
    {
        $this->db->query("DELETE from updates WHERE main_id = :id", ['id' => $id]);
        $this->db->query("DELETE from sub_work WHERE main_id = :id", ['id' => $id]);
        $this->db->query("DELETE FROM work WHERE id = :id", ['id' => $id]);
    }

    public function addSubWork($formData)
    {
        $assignedTo = "";
        if (isset($formData['addSubto'])) {
            $assignedTo = serialize($formData['addSubto']);
        }

        $this->db->query(
            "INSERT INTO sub_work (main_id, sub_subject, assigned_to, status) VALUES (:main_id, :sub_subject, :assigned_to, :status)",
            [
                'main_id' => $formData['mainId'],
                'sub_subject' => $formData['addSubSubject'],
                'assigned_to' => $assignedTo,
                'status' => "UNCOMPLIED"
            ]
        );
    }

    public function editSubWork($id)
    {
        $subWork = $this->db->query("SELECT * FROM sub_work WHERE id = :id", ['id' => $id])->find();
        $subAssigned = [];
        if ($subWork['assigned_to'] != "") {
            $subAssigned = unserialize($subWork['assigned_to']);
        }
        $assignedTo = $this->db->query("SELECT assigned_to FROM work where id = :id", ['id' => $subWork['main_id']])->find();
        $assignedTo = unserialize($assignedTo['assigned_to']);
        foreach ($assignedTo as $assigned) {
            $check = "";
            if (in_array($assigned, $subAssigned)) {
                $check = "checked";
            }


            $assignedDetails = $this->db->query("SELECT * FROM users WHERE id = :id", ['id' => $assigned])->find();
            $name = $assignedDetails['actual_rank'] . " " . $assignedDetails['last_name'] . " PAF";
            $assignedArray[] = ['id' => $assigned, 'picture' => $assignedDetails['picture'], 'name' => $name, 'check' => $check];
        }

        return ['subDetails' => $subWork, 'subAssigned' => $assignedArray];
    }

    public function saveEditSubWork($formData)
    {
        $assignedto = "";
        if (isset($formData['editSubto'])) {
            $assignedto = serialize($formData['editSubto']);
        }

        $this->db->query(
            "UPDATE sub_work SET sub_subject = :sub_subject, assigned_to = :assigned_to WHERE id = :id",
            [
                'sub_subject' => $formData['editSubSubject'],
                'assigned_to' => $assignedto,
                'id' => $formData['id']
            ]
        );
    }

    public function deleteSubWork($id)
    {
        $this->db->query("DELETE from updates WHERE sub_id = :id", ['id' => $id]);
        $this->db->query("DELETE from sub_work WHERE id = :id", ['id' => $id]);
    }

    public function updateWork($formData, $fileData)
    {
        $filetosave = "";
        if ($fileData['updateWorkFiles']['name'][0] != "") {
            $names = $_FILES['updateWorkFiles']['name'];
            $tmp_name = $_FILES['updateWorkFiles']['tmp_name'];
            $files_array = array_combine($tmp_name, $names);
            $filenamearray = array();
            foreach ($files_array as $tmp_folder => $file_name) {
                $fileExtension = pathinfo($file_name, PATHINFO_EXTENSION);
                $newFileName = bin2hex(random_bytes(16)) . "." . $fileExtension;
                $uploadpath = paths::STORAGE_UPLOADS_WORKREF . "/" . $newFileName;

                if (!move_uploaded_file($tmp_folder, $uploadpath)) {
                    throw new ValidationException(['receipt' => ["Failed to upload file!"]]);
                }
                array_push($filenamearray, $newFileName);
            }
            $filetosave = serialize($filenamearray);
        }
        $dateToday = date('Y-m-d');
        $this->db->query(
            "INSERT INTO updates (main_id, remarks, files, updated_by) VALUES (:main_id, :remarks, :files, :updated_by)",
            [
                'main_id' => $formData['idToUpdate'],
                'remarks' => $formData['updateRemarks'],
                'files' => $filetosave,
                'updated_by' => $_SESSION['user']['id']
            ]
        );
        $this->db->query(
            "UPDATE work SET updated_at = :updated_at WHERE id = :id",
            [
                'updated_at' => $dateToday,
                'id' => $formData['idToUpdate']
            ]
        );
    }

    public function updateSubWork($formData, $fileData)
    {
        $filetosave = "";
        if ($fileData['updateWorkFiles']['name'][0] != "") {
            $names = $_FILES['updateWorkFiles']['name'];
            $tmp_name = $_FILES['updateWorkFiles']['tmp_name'];
            $files_array = array_combine($tmp_name, $names);
            $filenamearray = array();
            foreach ($files_array as $tmp_folder => $file_name) {
                $fileExtension = pathinfo($file_name, PATHINFO_EXTENSION);
                $newFileName = bin2hex(random_bytes(16)) . "." . $fileExtension;
                $uploadpath = paths::STORAGE_UPLOADS_WORKREF . "/" . $newFileName;

                if (!move_uploaded_file($tmp_folder, $uploadpath)) {
                    throw new ValidationException(['receipt' => ["Failed to upload file!"]]);
                }
                array_push($filenamearray, $newFileName);
            }
            $filetosave = serialize($filenamearray);
        }
        $mainId = $this->db->query("SELECT main_id FROM sub_work WHERE id=:id", ['id' => $formData['subIdToUpdate']])->find();
        $this->db->query(
            "INSERT INTO updates (main_id, sub_id, remarks, files, updated_by) VALUES (:main_id, :sub_id, :remarks, :files, :updated_by)",
            [
                'main_id' => $mainId['main_id'],
                'sub_id' => $formData['subIdToUpdate'],
                'remarks' => $formData['updateRemarks'],
                'files' => $filetosave,
                'updated_by' => $_SESSION['user']['id']
            ]
        );
        $dateToday = date('Y-m-d');
        $this->db->query(
            "UPDATE work SET updated_at = :updated_at WHERE id = :id",
            [
                'updated_at' => $dateToday,
                'id' => $mainId['main_id']
            ]
        );
    }

    public function complySubWork($formData, $fileData)
    {
        $filetosave = "";
        if ($fileData['complyWorkFiles']['name'][0] != "") {
            $names = $_FILES['complyWorkFiles']['name'];
            $tmp_name = $_FILES['complyWorkFiles']['tmp_name'];
            $files_array = array_combine($tmp_name, $names);
            $filenamearray = array();
            foreach ($files_array as $tmp_folder => $file_name) {
                $fileExtension = pathinfo($file_name, PATHINFO_EXTENSION);
                $newFileName = bin2hex(random_bytes(16)) . "." . $fileExtension;
                $uploadpath = paths::STORAGE_UPLOADS_WORKREF . "/" . $newFileName;

                if (!move_uploaded_file($tmp_folder, $uploadpath)) {
                    throw new ValidationException(['receipt' => ["Failed to upload file!"]]);
                }
                array_push($filenamearray, $newFileName);
            }
            $filetosave = serialize($filenamearray);
        }

        $mainId = $this->db->query("SELECT main_id FROM sub_work WHERE id=:id", ['id' => $formData['subIdToComply']])->find();
        $this->db->query(
            "INSERT INTO updates (main_id, sub_id, remarks, files, final, updated_by) VALUES (:main_id, :sub_id, :remarks, :files, :final, :updated_by)",
            [
                'main_id' => $mainId['main_id'],
                'sub_id' => $formData['subIdToComply'],
                'remarks' => $formData['complyRemarks'],
                'files' => $filetosave,
                'final' => "YES",
                'updated_by' => $_SESSION['user']['id']
            ]
        );

        $this->db->query("UPDATE sub_work SET status = 'COMPLIED' WHERE id =:id", ['id' => $formData['subIdToComply']]);

        $dateToday = date('Y-m-d');
        $this->db->query(
            "UPDATE work SET updated_at = :updated_at WHERE id = :id",
            [
                'updated_at' => $dateToday,
                'id' => $mainId['main_id']
            ]
        );
    }

    public function complyWork($formData, $fileData)
    {
        $filetosave = "";
        if ($fileData['complyWorkFiles']['name'][0] != "") {
            $names = $_FILES['complyWorkFiles']['name'];
            $tmp_name = $_FILES['complyWorkFiles']['tmp_name'];
            $files_array = array_combine($tmp_name, $names);
            $filenamearray = array();
            foreach ($files_array as $tmp_folder => $file_name) {
                $fileExtension = pathinfo($file_name, PATHINFO_EXTENSION);
                $newFileName = bin2hex(random_bytes(16)) . "." . $fileExtension;
                $uploadpath = paths::STORAGE_UPLOADS_WORKREF . "/" . $newFileName;

                if (!move_uploaded_file($tmp_folder, $uploadpath)) {
                    throw new ValidationException(['receipt' => ["Failed to upload file!"]]);
                }
                array_push($filenamearray, $newFileName);
            }
            $filetosave = serialize($filenamearray);
        }

        $this->db->query(
            "INSERT INTO updates (main_id, remarks, files, final, updated_by) VALUES (:main_id, :remarks, :files, :final, :updated_by)",
            [
                'main_id' => $formData['IdToComply'],
                'remarks' => $formData['complyRemarks'],
                'files' => $filetosave,
                'final' => "YES",
                'updated_by' => $_SESSION['user']['id']
            ]
        );

        $targetDate = $this->db->query("SELECT date_target FROM work WHERE id = :id", ['id' => $formData['IdToComply']])->find();
        $targetDate = $targetDate['date_target'];
        $dateToday = date('Y-m-d');

        $timeliness = "No TD";
        if ($targetDate != "0000-00-00") {
            $targetDate = strtotime($targetDate);
            $dateToday = strtotime($dateToday);
            $interval = $targetDate - $dateToday;
            $daysinterval = floor($interval / (60 * 60 * 24));
            if ($daysinterval >= 1) {
                $timeliness = "Early";
            }
            if ($daysinterval == 0) {
                $timeliness = "On Time";
            }
            if ($daysinterval < 0) {
                $timeliness = "Late";
            }
        }


        $this->db->query(
            "UPDATE work SET status = :status, updated_at = :updated_at, date_complied = :date_complied, complied_by = :complied_by, timeliness = :timeliness WHERE id =:id",
            [
                'status' => "COMPLIED",
                'updated_at' => $dateToday,
                'date_complied' => $dateToday,
                'complied_by' => $_SESSION['user']['id'],
                'timeliness' => $timeliness,
                'id' => $formData['IdToComply']
            ]
        );
    }
}
