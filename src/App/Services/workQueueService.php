<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;
use Framework\Exceptions\ValidationException;
use App\config\paths;
use Dotenv\Store\File\Paths as FilePaths;

class workQueueService
{
    public string $userFullName;
    public string $userFullNameSN;
    public function __construct(private Database $db)
    {
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
                $res = checkUpdate($work['updated_at']);
                if ($res) {
                    $work['style'] = "background-color:orange; color:black";
                }
                if ($work['date_target'] != "0000-00-00") {
                    $res = checkDeadline($work['date_target']);
                    if ($res) {
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
        $allwork = $this->db->query("SELECT * FROM work WHERE status != 'COMPLIED' AND added_by = :id", ['id' => $id])->findAll();
        $myWork = [];
        foreach ($allwork as $work) {
            $assigned = unserialize($work['assigned_to']);
            $work['style'] = "background-color:none; color:black";
            $res = checkUpdate($work['updated_at']);
            if ($work['status'] != "PENDING") {
                if ($res) {
                    $work['style'] = "background-color:orange; color:black";
                }
                if ($work['date_target'] != "0000-00-00") {
                    $res = checkDeadline($work['date_target']);
                    if ($res) {
                        $work['style'] = "background-color:red; color:white";
                    }
                }
            }
            $myWork[] = $work;
        }
        return $myWork;
    }

    public function viewWorkHistory(int $id)
    {
        $allWork = $this->db->query("SELECT * FROM updates WHERE updated_by = :id ORDER BY id DESC", ['id' => $id])->findAll();
        $returnArray = [];
        foreach ($allWork as $work) {
            $workMainSubject = $this->db->query("SELECT subject FROM work WHERE id =:id", ['id' => $work['main_id']])->find();
            $workSubSubject['sub_subject'] = 0;
            if ($work['sub_id'] != 0) {
                $workSubSubject = $this->db->query("SELECT sub_subject FROM sub_work WHERE id = :id", ['id' => $work['sub_id']])->find();
            }
            $date = formatDate($work['created_at']);
            $returnArray[] = [
                'id' => $work['id'],
                'mainId' => $work['main_id'],
                'mainSubject' => $workMainSubject['subject'],
                'subSubject' => $workSubSubject['sub_subject'],
                'dateCreated' => $date,
                'remarks' => $work['remarks'],
                'files' => $work['files'],
                'final' => $work['final']
            ];
        }
        return $returnArray;
    }
}
