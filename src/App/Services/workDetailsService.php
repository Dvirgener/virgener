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

    public function editWork($id)
    {
        $workDetails = $this->db->query("SELECT *, DATE_FORMAT(date_target, '%Y-%m-%d') as formatted_date FROM work WHERE id = :id", ['id' => $id])->find();
        $workDetails['assigned_to'] = unserialize($workDetails['assigned_to']);
        return $workDetails;
    }

    public function saveEditedWork(array $formData, ?array $fileData)
    {
        $assigned = serialize($formData['addto']);
        $formattedDate = "{$formData['addworktargetdate']}) 00:00:00";
        if ($fileData['workfiles']['name'][0] != "") {
            $fileNameArray = saveFile($fileData);
            $filetosave = serialize($fileNameArray);
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

    public function deleteWork($id)
    {
        $this->db->query("DELETE from updates WHERE main_id = :id", ['id' => $id]);
        $this->db->query("DELETE from sub_work WHERE main_id = :id", ['id' => $id]);
        $this->db->query("DELETE FROM work WHERE id = :id", ['id' => $id]);
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

    public function deleteSubWork($id)
    {
        $this->db->query("DELETE from updates WHERE sub_id = :id", ['id' => $id]);
        $this->db->query("DELETE from sub_work WHERE id = :id", ['id' => $id]);
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

        $this->db->query("DELETE FROM updates WHERE id = :id", ['id' => $params['id']]);
    }


    public function updateWork($formData, $fileData)
    {
        $filetosave = "";
        if ($fileData['workfiles']['name'][0] != "") {
            $fileNameArray = saveFile($fileData);
            $filetosave = serialize($fileNameArray);
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
        if ($fileData['workfiles']['name'][0] != "") {
            $fileNameArray = saveFile($fileData);
            $filetosave = serialize($fileNameArray);
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
        if ($fileData['workfiles']['name'][0] != "") {
            $fileNameArray = saveFile($fileData);
            $filetosave = serialize($fileNameArray);
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
        if ($fileData['workfiles']['name'][0] != "") {
            $fileNameArray = saveFile($fileData);
            $filetosave = serialize($fileNameArray);
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
                'status' => "PENDING",
                'updated_at' => $dateToday,
                'date_complied' => $dateToday,
                'complied_by' => $_SESSION['user']['id'],
                'timeliness' => $timeliness,
                'id' => $formData['IdToComply']
            ]
        );
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
}
