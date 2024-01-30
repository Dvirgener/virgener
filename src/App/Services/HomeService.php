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
    private function workNumbers($id):array {
        $allActiveWork = $this->db->query("SELECT * FROM work WHERE status = 'UNCOMPLIED'")->findAll();
        $activeWork = 0;
        $forFollowUp = 0;
        $deadline = 0;
        foreach($allActiveWork as $work){
            $work['assigned_to'] = unserialize($work['assigned_to']);
            if (in_array($id,$work['assigned_to'])){
                $activeWork +=1;
                $res = checkUpdate($work['updated_at']);
                if ($res) {
                    $forFollowUp +=1;
                }
                if ($work['date_target'] != "0000-00-00") {
                    $res = checkDeadline($work['date_target']);
                    if ($res) {
                        $deadline+=1;
                    }
                }
            }
        }
        return ['active' => $activeWork, 'update' => $forFollowUp, 'deadline' => $deadline];
    }

    // * This function is for all the work queue created in DB (PIE CHART)
    public function allWorkQueue()
    {
        $allUncomplied = $this->db->query("SELECT COUNT(*) as count FROM work WHERE status = 'UNCOMPLIED'")->find();
        $allPending = $this->db->query("SELECT COUNT(*) as count FROM work WHERE status = 'PENDING'")->find();
        $allComplied = $this->db->query("SELECT COUNT(*) as count FROM work WHERE status = 'COMPLIED'")->find();
        $all = $allUncomplied['count'] + $allPending['count'] + $allComplied['count'];
        return ['uncomplied' => $allUncomplied['count'], 'pending'=>$allPending['count'],'complied' => $allComplied['count'],'all' => $all];
    }

    // * This function is for rendering the Work Details of individual personnel registered
    public function allUsers(){
        $DbUsers = $this->db->query("SELECT * FROM users WHERE classification = 'EP'")->findAll();
        $users = [];
        foreach ($DbUsers as $user){
            $individual['name'] = $user['actual_rank']." ".$user['first_name']." ".$user['last_name']." ".$user['serial_number']." PAF";
            $individual['status'] = $user['status'];
            $individual['picture'] = $user['picture'];
            $individual['workNumbers'] = $this->workNumbers($user['id']);
            $individual['numberRank'] = $user['number_rank'];
            $users[] = $individual;
        }

        $keys = array_column($users, 'numberRank');
        array_multisort($keys, SORT_DESC, $users);
        return $users;
    }

    // * This function is for all the work queue complied in DB (PIE CHART)
    public function timelinessNumbers()
    {
        $allEarly = $this->db->query("SELECT COUNT(*) as count FROM work WHERE status = 'COMPLIED' AND timeliness = 'Early'")->find();
        $allOnTime = $this->db->query("SELECT COUNT(*) as count FROM work WHERE status = 'COMPLIED' and timeliness = 'On Time'")->find();
        $allLate = $this->db->query("SELECT COUNT(*) as count FROM work WHERE status = 'COMPLIED' and timeliness = 'Late'")->find();
        $allNoTD = $this->db->query("SELECT COUNT(*) as count FROM work WHERE status = 'COMPLIED' and timeliness = 'No TD'")->find();
        return ['early' => $allEarly['count'], 'onTime'=>$allOnTime['count'],'late' => $allLate['count'],'noTD' => $allNoTD['count']];
    }

    // * This function is for all the work queue complied in DB (PIE CHART)
    public function activeWorkNumbers()
    {
        $workQueues = $this->db->query("SELECT * FROM work WHERE status = 'UNCOMPLIED'")->findAll();
        $activeForUpdate = 0;
        $activeNearDeadline = 0;
        $activeUpdated = 0;
        $activeCount = 0;
        foreach($workQueues as $work){
            $activeCount +=1;

            if ($work['date_target'] != "0000-00-00") {
                if (checkDeadline($work['date_target'])) {
                    $activeNearDeadline+=1;
                    continue;
                }
            }

            if (checkUpdate($work['updated_at'])) {
                $activeForUpdate+=1;
                continue;
            }

            $activeUpdated +=1;

            
        }

        return ['active' => $activeCount, 'forUpdate' => $activeForUpdate,'nearDeadline' => $activeNearDeadline,'updated' => $activeUpdated];

    }


    public function updatesToday ():array{
        $today = date('Y-m-d');

        $updatesToday = $this->db->query("SELECT * FROM updates WHERE created_at = :created_at ORDER BY id DESC",['created_at'=> $today])->findAll();

        $updatesArray = [];
        foreach ($updatesToday as $updates){

            $update['id'] = $updates['id'];
            // * Main Work Subject
            $mainWork = $this->db->query("SELECT subject FROM work WHERE id =:id",['id' => $updates['main_id']])->find();
            $update['mainWork'] = $mainWork['subject'];

            // * Check For Sub Work and Assign Sub Subject
            $update['subWork'] = "";
            if ($updates['sub_id'] != 0){
                $subWork = $this->db->query("SELECT sub_subject FROM sub_work WHERE id =:id",['id' => $updates['sub_id']])->find();
                $update['subWork'] = "(".$subWork['sub_subject'].")";
            }

            $update['remarks'] = $updates['remarks'];

            $updatedBy = $this->db->query("SELECT * FROM users WHERE id = :id", ['id' => $updates['updated_by']])->find();
            $update['name'] = $updatedBy['actual_rank']. " ". $updatedBy['last_name']. " PAF";

            $update['compliance'] = "";
            if ($updates['final'] == 'YES'){
            $update['compliance'] = "Compliance remarks!";
            }
            $updatesArray[] = $update;
        }

        return $updatesArray;
    }




}
