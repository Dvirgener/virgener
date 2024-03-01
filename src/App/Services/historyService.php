<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;
use Framework\Exceptions\ValidationException;
use App\config\paths;
use Dotenv\Store\File\Paths as FilePaths;

class historyService
{
    public string $userFullName;
    public string $userFullNameSN;

    public function __construct(private Database $db)
    {
    }

    // * Private functions to be used inside this class. to reduce redundant codes
    private function nameOfId($id)
    {
        $user = $this->db->query("SELECT * FROM users WHERE id = :id", ['id' => $id])->find();
        return $name = $user['actual_rank'] . " " . $user['last_name'] . " PAF";
    }

    public function getCompliedWork()
    {
        $compliedWork = $this->db->query("SELECT * FROM work WHERE status = 'COMPLIED' ORDER BY date_complied DESC", [])->findAll();
        $workDetails = [];
        foreach ($compliedWork as $work) {
            $addedBy = $this->nameOfId($work['added_by']);
            // * format date to be readable
            $date = date_create($work['date_complied']);
            $dateComplied = date_format($date, "d F Y");
            switch ($work['timeliness']) {
                case "Early":
                    $timeColor = 'green';
                    break;
                case "On Time":
                    $timeColor = 'orange';
                    break;
                case "Late":
                    $timeColor = 'red';
                    break;
                case "No TD":
                    $timeColor = 'black';
                    break;
            }
            $workDetails[] = [
                'id' => $work['id'],
                'subject' => $work['subject'],
                'addedBy' => $addedBy,
                'timeliness' => $work['timeliness'],
                'dateComplied' => $dateComplied,
                'timeColor' => $timeColor
            ];
        }
        return $workDetails;
    }
}
