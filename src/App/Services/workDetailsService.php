<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;
use Framework\Exceptions\ValidationException;
use App\config\paths;
use Dotenv\Store\File\Paths as FilePaths;

class workDetailsService
{

    public function __construct(private Database $db)
    {
    }

    // * Private functions to be used inside this class. to reduce redundant codes
    private function nameOfId($id)
    {
        $user = $this->db->query("SELECT * FROM users WHERE id = :id", ['id' => $id])->find();
        return $name = $user['actual_rank'] . " " . $user['last_name'] . " PAF";
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
        $workUpdates = $this->db->query("SELECT * FROM updates WHERE main_id = :main_id ORDER BY id ASC", ['main_id' => $workId])->findAll();

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
                $subStatus['comp'] = ['bg' => ' complied!', 'compBut' => "disabled"];
            }
            //  * Check if sub work assignee is not empty
            if (!empty($subStatus['assigned_to'])) {
                $subAssigned = unserialize($subStatus['assigned_to']);
                $assignedName = [];
                $authBut = "not";
                // * variable for disabling / enabling comply button
                if (in_array($_SESSION['user']['id'], $subAssigned)) {
                    $authBut = "do";
                }
                // * assign names for each assigned user
                foreach ($subAssigned as $id) {
                    $assignedName[] = $this->nameOfId($id);
                }
                $subStatus['assignedNames'] = $assignedName;
                $subStatus['authBut'] = $authBut;
                $finalSubWorkList[] = $subStatus;
            } else {
                $subStatus['authBut'] = "do";
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

    public function getSubwork($mainId)
    {
        return $this->db->query("SELECT * FROM sub_work WHERE main_id = :main_id", ['main_id' => $mainId])->findAll();
    }

    public function getUpdates($workId, $subId)
    {
        if ($subId == 0) {
            $workUpdates = $this->db->query("SELECT * FROM updates WHERE main_id = :main_id AND sub_id = 0", ['main_id' => $workId])->findAll();
        } else if ($subId == "all") {
            $workUpdates = $this->db->query("SELECT * FROM updates WHERE main_id = :main_id", ['main_id' => $workId])->findAll();
        } else {
            $workUpdates = $this->db->query("SELECT * FROM updates WHERE main_id = :main_id AND sub_id = :sub_id", ['main_id' => $workId, 'sub_id' => $subId])->findAll();
        }

        // *Scan Each work updates for details
        $detailedWorkUpdates = [];
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
        return $detailedWorkUpdates;
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

    public function editWork($id)
    {
        $workDetails = $this->db->query("SELECT *, DATE_FORMAT(date_target, '%Y-%m-%d') as formatted_date FROM work WHERE id = :id", ['id' => $id])->find();
        $workDetails['assigned_to'] = unserialize($workDetails['assigned_to']);
        return $workDetails;
    }

    public function saveEditedWork(array $formData)
    {

        $assigned = serialize($formData['addto']);
        $formattedDate = "{$formData['addworktargetdate']}) 00:00:00";

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

    public function deleteWork(int $id)
    {
        $filesToDelete = [];

        // * Select Main work Files
        $mainWorkFiles = $this->db->query("SELECT files FROM work WHERE id = :id", ['id' => $id])->find();
        $mainWorkFiles = $mainWorkFiles['files'];
        if (!empty($mainWorkFiles)) {
            $mainWorkFiles = unserialize($mainWorkFiles);
            array_push($filesToDelete, ...$mainWorkFiles);
        }

        // * Select all update files from work;
        $allUpdateFiles = $this->db->query("SELECT files FROM updates WHERE main_id = :id", ['id' => $id])->findAll();
        foreach ($allUpdateFiles as $update) {
            if (!empty($update['files'])) {
                $files = unserialize($update['files']);
                array_push($filesToDelete, ...$files);
            }
        }

        $this->db->query("DELETE from updates WHERE main_id = :id", ['id' => $id]);
        $this->db->query("DELETE from sub_work WHERE main_id = :id", ['id' => $id]);
        $this->db->query("DELETE FROM work WHERE id = :id", ['id' => $id]);

        return $filesToDelete;
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

    public function getWorkId($id)
    {
        $workId = $this->db->query("SELECT main_id FROM sub_work WHERE id = :id", ['id' => $id])->find();
        return $workId['main_id'];
    }

    public function deleteSubWork(int $id)
    {
        $filesToDelete = [];
        // * Select all update files from work;
        $allUpdateFiles = $this->db->query("SELECT files FROM updates WHERE sub_id = :id", ['id' => $id])->findAll();
        foreach ($allUpdateFiles as $update) {
            if (!empty($update['files'])) {
                $files = unserialize($update['files']);
                array_push($filesToDelete, ...$files);
            }
        }

        $this->db->query("DELETE from updates WHERE sub_id = :id", ['id' => $id]);
        $this->db->query("DELETE from sub_work WHERE id = :id", ['id' => $id]);
        return $filesToDelete;
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

    public function deleteUpdate(array $params)
    {
        $updateDetails = $this->db->query("SELECT * FROM updates WHERE id = :id", ['id' => $params['id']])->find();
        if ($updateDetails['sub_id'] != 0) {
            if ($updateDetails['final'] == "YES") {
                $this->db->query("UPDATE sub_work SET status = :status WHERE id = :id", ['status' => "UNCOMPLIED", 'id' => $updateDetails['sub_id']]);
            }
        } else {
            if ($updateDetails['final'] == "YES") {
                $this->db->query("UPDATE work SET status = :status WHERE id = :id", ['status' => "UNCOMPLIED", 'id' => $updateDetails['main_id']]);
            }
        }

        if (!empty($updateDetails['files'])) {
            $updateFiles = unserialize($updateDetails['files']);
        }

        $this->db->query("DELETE FROM updates WHERE id = :id", ['id' => $params['id']]);
        return $updateFiles;
    }


    public function updateWork(array $formData)
    {
        $dateToday = date('Y-m-d');
        if ($formData['updateId'] == 0) {
            $this->db->query(
                "INSERT INTO updates (main_id, remarks, updated_by) VALUES (:main_id, :remarks, :updated_by)",
                [
                    'main_id' => $formData['main_id'],
                    'remarks' => $formData['updateRemarks'],
                    'updated_by' => $_SESSION['user']['id']
                ]
            );

            $id = $this->db->id();

            $this->db->query(
                "UPDATE work SET updated_at = :updated_at WHERE id = :id",
                [
                    'updated_at' => $dateToday,
                    'id' => $formData['main_id']
                ]
            );
            return $id;
        } else {
            $this->db->query(
                "INSERT INTO updates (main_id, sub_id, remarks, updated_by) VALUES (:main_id, :sub_id, :remarks, :updated_by)",
                [
                    'main_id' => $formData['main_id'],
                    'sub_id' => $formData['updateId'],
                    'remarks' => $formData['updateRemarks'],
                    'updated_by' => $_SESSION['user']['id']
                ]
            );
            $id = $this->db->id();
            $dateToday = date('Y-m-d');
            $this->db->query(
                "UPDATE work SET updated_at = :updated_at WHERE id = :id",
                [
                    'updated_at' => $dateToday,
                    'id' => $formData['main_id']
                ]
            );
            return $id;
        }
    }

    public function updateSubWork(array $formData)
    {
        $mainId = $this->db->query("SELECT main_id FROM sub_work WHERE id=:id", ['id' => $formData['subIdToUpdate']])->find();
        $this->db->query(
            "INSERT INTO updates (main_id, sub_id, remarks, updated_by) VALUES (:main_id, :sub_id, :remarks, :updated_by)",
            [
                'main_id' => $mainId['main_id'],
                'sub_id' => $formData['subIdToUpdate'],
                'remarks' => $formData['updateRemarks'],
                'updated_by' => $_SESSION['user']['id']
            ]
        );
        $id = $this->db->id();
        $dateToday = date('Y-m-d');
        $this->db->query(
            "UPDATE work SET updated_at = :updated_at WHERE id = :id",
            [
                'updated_at' => $dateToday,
                'id' => $mainId['main_id']
            ]
        );
        return $id;
    }

    public function complySubWork(array $formData)
    {
    }

    public function complyWork($formData)
    {
        $dateToday = date('Y-m-d');
        if ($formData['complyId'] == 0) {
            $this->db->query(
                "INSERT INTO updates (main_id, remarks, final, updated_by) VALUES (:main_id, :remarks, :final, :updated_by)",
                [
                    'main_id' => $formData['main_id'],
                    'remarks' => $formData['complyRemarks'],
                    'final' => "YES",
                    'updated_by' => $_SESSION['user']['id']
                ]
            );
            $id = $this->db->id();

            $targetDate = $this->db->query("SELECT date_target FROM work WHERE id = :id", ['id' => $formData['main_id']])->find();
            $targetDate = $targetDate['date_target'];

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
                    'status' => "PENDING",
                    'updated_at' => $dateToday,
                    'date_complied' => $dateToday,
                    'complied_by' => $_SESSION['user']['id'],
                    'timeliness' => $timeliness,
                    'id' => $formData['main_id']
                ]
            );

            return ['complyFrom' => "mainWork", 'id' => $id];
        } else {
            $this->db->query(
                "INSERT INTO updates (main_id, sub_id, remarks, final, updated_by) VALUES (:main_id, :sub_id, :remarks, :final, :updated_by)",
                [
                    'main_id' => $formData['main_id'],
                    'sub_id' => $formData['complyId'],
                    'remarks' => $formData['complyRemarks'],
                    'final' => "YES",
                    'updated_by' => $_SESSION['user']['id']
                ]
            );
            $id = $this->db->id();

            $this->db->query("UPDATE sub_work SET status = 'COMPLIED' WHERE id =:id", ['id' => $formData['complyId']]);

            $this->db->query(
                "UPDATE work SET updated_at = :updated_at WHERE id = :id",
                [
                    'updated_at' => $dateToday,
                    'id' => $formData['main_id']
                ]
            );
            return ['complyFrom' => "subWork", 'id' => $id];
        }
    }

    public function confirmCompliance($id)
    {
        $this->db->query("UPDATE work SET status = :status WHERE id = :id", ['status' => "COMPLIED", 'id' => $id]);
    }

    public function returnCompliance($id)
    {
        $lastUpdate = $this->db->query("SELECT * FROM updates WHERE main_id = :main_id ORDER BY id DESC LIMIT 1", ['main_id' => $id])->find();

        $this->db->query("DELETE FROM updates WHERE id = :id", ['id' => $lastUpdate['id']]);

        $this->db->query("UPDATE work SET status = :status WHERE id = :id", ['status' => "UNCOMPLIED", 'id' => $id]);
    }

    public function getUpdateDetail(int $id)
    {
        $updateDetails = $this->db->query("SELECT * FROM updates WHERE id = :id", ['id' => $id])->find();
        return $updateDetails;
    }

    public function saveEditUpdate(array $formData)
    {
        $this->db->query("UPDATE updates SET remarks = :remarks WHERE id = :id", ['remarks' => $formData['updateRemarks'], 'id' => $formData['updateId']]);
    }
}
