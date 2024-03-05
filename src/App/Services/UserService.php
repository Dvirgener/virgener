<?php

declare(strict_types=1);

namespace App\Services;


use Framework\Database;
use Framework\Exceptions\ValidationException;

class UserService
{
    public function __construct(private Database $db)
    {
    }

    // * This private function get the Rank, Last name, and picture of users selected
    private function GetArrayOfUsers(array $users, int $loggedSerialNumber = 0, int $loggedNumberRank = 0)
    {
        $returnArray = [];
        foreach ($users as $user) {
            $userDetails = $this->db->query("SELECT * FROM users WHERE id =:id", ['id' => $user])->find();
            if ($userDetails['serial_number'] < $loggedSerialNumber && $loggedSerialNumber != 0) {
                continue;
            }
            if ($userDetails['number_rank'] > $loggedNumberRank && $loggedNumberRank != 0) {
                continue;
            }
            $userName = $userDetails['actual_rank'] . " " . $userDetails['last_name'] . " PAF";
            $returnArray[] = [
                'id' => $user,
                'name' => $userName,
                'numberRank' => $userDetails['number_rank'],
                'serialNumber' => $userDetails['serial_number'],
                'status' => $userDetails['status'],
                'picture' => $userDetails['picture']
            ];
        }
        return $returnArray;
    }

    // * Check if an email is Taken
    public function isEmailTaken(string $email)
    {
        $emailCount = $this->db->query("SELECT COUNT(*) FROM users WHERE email = :email", ['email' => $email])->count();

        if ($emailCount > 0) {
            throw new ValidationException(['email' => array('Email already Taken!')]);
        }
    }

    // * register a user if there has no validation error
    public function registerUser(array $form)
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

        $password = password_hash($form['password'], PASSWORD_BCRYPT, ['cost => 12']);

        $this->db->query(
            "INSERT INTO users (email, password, first_name, last_name, actual_rank, number_rank, serial_number, position, authority)
            VALUES (:email,:password,:first_name,:last_name,:actual_rank,:number_rank,:serial_number,:position,:authority)",
            [
                'email' => $form['email'],
                'password' => $password,
                'first_name' => $form['firstName'],
                'last_name' => $form['lastName'],
                'actual_rank' => $actual_rank,
                'number_rank' => $form['rank'],
                'serial_number' => $form['serialNumber'],
                'position' => $form['position'],
                'authority' => "karaoke"
            ]
        );

        session_regenerate_id();
    }

    // * Login user to the app
    public function loginUser(array $formData)
    {
        $password = password_hash($formData['password'], PASSWORD_BCRYPT);

        $user = $this->db->query(
            "SELECT * FROM users WHERE email = :email",
            ['email' => $formData['email']]
        )->find();

        $passwordsMatch = password_verify($formData['password'], $user['password'] ?? '');

        if (!$user || !$passwordsMatch) {
            throw new ValidationException(['password' => ['invalid Credentials']]);
        }

        session_regenerate_id();

        $_SESSION['user'] = $user;
    }


    // * Check for the users assigned in the section given
    public function usersInSection(string $section)
    {
        $allUsers = $this->db->query("SELECT * FROM users WHERE classification = 'EP'")->findAll();
        foreach ($allUsers as $user) {
            $assignment = unserialize($user['section']);
            if (in_array($section, $assignment)) {
                $users[] = $user['id'];
            }
        }
        return $this->GetArrayOfUsers($users);
    }

    public function subordinateOfUser(int $id)
    {
        $loggedUser = $this->db->query("SELECT * FROM users WHERE id = :id", ['id' => $id])->find();
        switch ($loggedUser['position']) {
            case "OIC":
                $fetchedIds = $this->db->query("SELECT id FROM users ORDER BY serial_number")->findall();
                foreach ($fetchedIds as $fetched) {
                    $allUnder[] = $fetched['id'];
                }
                break;
            case "AOIC":
                $fetchedIds = $this->db->query("SELECT id FROM users  WHERE position != 'OIC' ORDER BY serial_number")->findAll();
                foreach ($fetchedIds as $fetched) {
                    $allUnder[] = $fetched['id'];
                }
                break;
            case "NCOIC":
            case "Personnel":
                $fetchedIds = $this->db->query("SELECT id FROM users WHERE classification = 'EP'  ORDER BY serial_number")->findAll();
                foreach ($fetchedIds as $fetched) {
                    $allUnder[] = $fetched['id'];
                }
                break;
        }
        return $this->GetArrayOfUsers($allUnder, $loggedUser['serial_number'], $loggedUser['number_rank']);
    }

    // * Logout User
    public function logout()
    {
        // unset($_SESSION['user']);
        session_destroy();
        // session_regenerate_id();
        $params = session_get_cookie_params();
        setcookie(
            'PHPSESSID',
            '',
            time(),
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }
}
