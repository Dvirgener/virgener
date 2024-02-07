<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;
use Framework\Exceptions\ValidationException;
use App\config\paths;
use Dotenv\Store\File\Paths as FilePaths;

class settingsService
{
    public string $userFullName;
    public string $userFullNameSN;
    public function __construct(private Database $db)
    {
    }

    // * Function for updating the Profile pic of the user
    public function updateUserProfilePic(?array $fileData)
    {
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

    // * Function for Updating the User's Details in the DB
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

    // * Getting user details from DB for use of _profile partials
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
}
