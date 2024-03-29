<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;

class HomeService
{
    public function __construct(private Database $db)
    {
    }

    // * Private function to fetch number of Work Queue per Personnel
    private function workNumbers($id): array
    {
        $allActiveWork = $this->db->query("SELECT * FROM work WHERE status = 'UNCOMPLIED'")->findAll();
        $activeWork = 0;
        $forFollowUp = 0;
        $deadline = 0;
        foreach ($allActiveWork as $work) {
            $work['assigned_to'] = unserialize($work['assigned_to']);
            if (in_array($id, $work['assigned_to'])) {
                $activeWork += 1;
                $res = checkUpdate($work['updated_at']);
                if ($res) {
                    $forFollowUp += 1;
                }
                if ($work['date_target'] != "0000-00-00") {
                    $res = checkDeadline($work['date_target']);
                    if ($res) {
                        $deadline += 1;
                    }
                }
            }
        }
        return ['active' => $activeWork, 'update' => $forFollowUp, 'deadline' => $deadline];
    }

    // * Private functions to be used inside this class. to reduce redundant codes
    private function nameOfId(int $id)
    {
        $user = $this->db->query("SELECT * FROM users WHERE id = :id", ['id' => $id])->find();
        $name = $user['actual_rank'] . " " . $user['last_name'] . " PAF";
        $picture = $user['picture'];
        return ['name' => $name, 'picture' => $picture];
    }

    // * This function is for rendering the Work Details of individual personnel registered
    public function allUsers()
    {
        $DbUsers = $this->db->query("SELECT * FROM users WHERE classification = 'EP'")->findAll();
        $users = [];
        foreach ($DbUsers as $user) {
            $individual['name'] = $user['actual_rank'] . " " . $user['first_name'] . " " . $user['last_name'] . " " . $user['serial_number'] . " PAF";
            $individual['status'] = $user['status'];
            $individual['picture'] = $user['picture'];
            $individual['workNumbers'] = $this->workNumbers($user['id']);
            $individual['numberRank'] = $user['number_rank'];
            $individual['id'] = $user['id'];
            $users[] = $individual;
        }

        $keys = array_column($users, 'numberRank');
        array_multisort($keys, SORT_DESC, $users);
        return $users;
    }

    // * This function is for all the work queue created in DB (PIE CHART)
    public function allWorkQueue()
    {
        $allUncomplied = $this->db->query("SELECT COUNT(*) as count FROM work WHERE status = 'UNCOMPLIED'")->find();
        $allPending = $this->db->query("SELECT COUNT(*) as count FROM work WHERE status = 'PENDING'")->find();
        $allComplied = $this->db->query("SELECT COUNT(*) as count FROM work WHERE status = 'COMPLIED'")->find();
        $all = $allUncomplied['count'] + $allPending['count'] + $allComplied['count'];
        return ['uncomplied' => $allUncomplied['count'], 'pending' => $allPending['count'], 'complied' => $allComplied['count'], 'all' => $all];
    }

    // * This function is for all the work queue complied in DB (PIE CHART)
    public function timelinessNumbers()
    {
        $allEarly = $this->db->query("SELECT COUNT(*) as count FROM work WHERE status = 'COMPLIED' AND timeliness = 'Early'")->find();
        $allOnTime = $this->db->query("SELECT COUNT(*) as count FROM work WHERE status = 'COMPLIED' and timeliness = 'On Time'")->find();
        $allLate = $this->db->query("SELECT COUNT(*) as count FROM work WHERE status = 'COMPLIED' and timeliness = 'Late'")->find();
        $allNoTD = $this->db->query("SELECT COUNT(*) as count FROM work WHERE status = 'COMPLIED' and timeliness = 'No TD'")->find();
        return ['early' => $allEarly['count'], 'onTime' => $allOnTime['count'], 'late' => $allLate['count'], 'noTD' => $allNoTD['count']];
    }

    // * This function is for all the work queue complied in DB (PIE CHART)
    public function activeWorkNumbers()
    {
        $workQueues = $this->db->query("SELECT * FROM work WHERE status = 'UNCOMPLIED'")->findAll();
        $activeForUpdate = 0;
        $activeNearDeadline = 0;
        $activeUpdated = 0;
        $activeCount = 0;
        foreach ($workQueues as $work) {
            $activeCount += 1;
            if ($work['date_target'] != "0000-00-00") {
                if (checkDeadline($work['date_target'])) {
                    $activeNearDeadline += 1;
                    continue;
                }
            }
            if (checkUpdate($work['updated_at'])) {
                $activeForUpdate += 1;
                continue;
            }
            $activeUpdated += 1;
        }
        return ['active' => $activeCount, 'forUpdate' => $activeForUpdate, 'nearDeadline' => $activeNearDeadline, 'updated' => $activeUpdated];
    }

    // * Function for returning queues that were updated today
    public function updatesToday(): array
    {
        $today = date('Y-m-d');

        $updatesToday = $this->db->query("SELECT * FROM updates WHERE created_at = :created_at ORDER BY id DESC", ['created_at' => $today])->findAll();

        $updatesArray = [];
        foreach ($updatesToday as $updates) {

            $update['id'] = $updates['id'];
            // * Main Work Subject
            $mainWork = $this->db->query("SELECT subject FROM work WHERE id =:id", ['id' => $updates['main_id']])->find();
            $update['mainWork'] = $mainWork['subject'];

            // * Check For Sub Work and Assign Sub Subject
            $update['subWork'] = "";
            if ($updates['sub_id'] != 0) {
                $subWork = $this->db->query("SELECT sub_subject FROM sub_work WHERE id =:id", ['id' => $updates['sub_id']])->find();
                $update['subWork'] = $subWork['sub_subject'];
            }

            $update['remarks'] = $updates['remarks'];

            // * Updated by name
            $updatedBy = $this->db->query("SELECT * FROM users WHERE id = :id", ['id' => $updates['updated_by']])->find();
            $update['name'] = $updatedBy['actual_rank'] . " " . $updatedBy['last_name'] . " PAF";

            $update['compliance'] = "";
            if ($updates['final'] == 'YES') {
                $update['compliance'] = "Complied!";
            }
            $updatesArray[] = $update;
        }
        return $updatesArray;
    }

    // * Function for returning queues that are recently added (12 queues)
    public function RecentlyAdded(): array
    {
        $allActiveWorkQueue = $this->db->query("SELECT * FROM work WHERE status = 'UNCOMPLIED' ORDER BY created_at DESC LIMIT 12")->findAll();

        $returnArray = [];

        foreach ($allActiveWorkQueue as $workQueue) {
            $workQueue['assignment'] = [];
            $name = $this->nameOfId($workQueue['added_by']);
            $workQueue['added_by'] = $name['name'];
            $assignedUsers = unserialize($workQueue['assigned_to']);

            foreach ($assignedUsers as $users) {
                $userNameAndPic = $this->nameOfId((int) $users);
                $user = [$users, $userNameAndPic];
                $workQueue['assignment'][] = $user;
            }

            $returnArray[] = $workQueue;
        }

        return $returnArray;
    }

    // * Function for returning queues that are recently Complied (10 queues)
    public function recentlyComplied(): array
    {
        $allActiveWorkQueue = $this->db->query("SELECT * FROM work WHERE status = 'COMPLIED' ORDER BY created_at DESC LIMIT 10")->findAll();

        $returnArray = [];

        foreach ($allActiveWorkQueue as $workQueue) {
            $workQueue['assignment'] = [];
            $name = $this->nameOfId($workQueue['added_by']);
            $workQueue['added_by'] = $name['name'];
            $assignedUsers = unserialize($workQueue['assigned_to']);

            foreach ($assignedUsers as $users) {
                $userNameAndPic = $this->nameOfId((int) $users);
                $user = [$users, $userNameAndPic];
                $workQueue['assignment'][] = $user;
            }

            $returnArray[] = $workQueue;
        }

        return $returnArray;
    }

    // * Function for returning queues that are for follow up and needs to be updated
    public function followUp(): array
    {
        $allActiveWorkQueue = $this->db->query("SELECT * FROM work WHERE status = 'UNCOMPLIED'")->findAll();

        $returnArray = [];

        foreach ($allActiveWorkQueue as $workQueue) {
            $workQueue['assignment'] = [];
            $name = $this->nameOfId($workQueue['added_by']);
            $workQueue['added_by'] = $name['name'];
            $assignedUsers = unserialize($workQueue['assigned_to']);

            foreach ($assignedUsers as $users) {
                $userNameAndPic = $this->nameOfId((int) $users);
                $user = [$users, $userNameAndPic];
                $workQueue['assignment'][] = $user;
            }

            if (checkUpdate($workQueue['updated_at'])) {
                if ($workQueue['date_target'] != "0000-00-00") {
                    if (checkDeadline($workQueue['date_target'])) {
                        continue;
                    }
                }
                $returnArray[] = $workQueue;
            }
        }

        return $returnArray;
    }

    // * Function for returning queuest that are near the deadline set
    public function deadline(): array
    {
        $allActiveWorkQueue = $this->db->query("SELECT * FROM work WHERE status = 'UNCOMPLIED'")->findAll();

        $returnArray = [];

        foreach ($allActiveWorkQueue as $workQueue) {
            $workQueue['assignment'] = [];
            $name = $this->nameOfId($workQueue['added_by']);
            $workQueue['added_by'] = $name['name'];
            $assignedUsers = unserialize($workQueue['assigned_to']);

            foreach ($assignedUsers as $users) {
                $userNameAndPic = $this->nameOfId((int) $users);
                $user = [$users, $userNameAndPic];
                $workQueue['assignment'][] = $user;
            }
            if ($workQueue['date_target'] != "0000-00-00") {
                if (checkDeadline($workQueue['date_target'])) {
                    $returnArray[] = $workQueue;
                }
            }
        }

        return $returnArray;
    }

    // * Function for returning queues that are complied but is pending approval of the adder
    public function pending(): array
    {
        $allActiveWorkQueue = $this->db->query("SELECT * FROM work WHERE status = 'PENDING'")->findAll();

        $returnArray = [];

        foreach ($allActiveWorkQueue as $workQueue) {
            $workQueue['assignment'] = [];
            $name = $this->nameOfId($workQueue['added_by']);
            $workQueue['added_by'] = $name['name'];
            $assignedUsers = unserialize($workQueue['assigned_to']);

            foreach ($assignedUsers as $users) {
                $userNameAndPic = $this->nameOfId((int) $users);
                $user = [$users, $userNameAndPic];
                $workQueue['assignment'][] = $user;
            }

            $returnArray[] = $workQueue;
        }

        return $returnArray;
    }

    // * Function to render user profile in view only mode
    public function renderUserProfile($id)
    {

        $userDetails = $this->db->query("SELECT * FROM users WHERE id = :id", ['id' => $id])->find();
        $userDetails['FullName'] = $userDetails['actual_rank'] . " " . $userDetails['first_name'] . " " . $userDetails['last_name'] . " PAF";
        $userDetails['FullNameSN'] = $userDetails['actual_rank'] . " " . $userDetails['first_name'] . " " . $userDetails['last_name'] . " " . $userDetails['serial_number'] . " PAF";
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
}
