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

    public function isEmailTaken(string $email)
    {
        $emailCount = $this->db->query("SELECT COUNT(*) FROM users WHERE email = :email", ['email' => $email])->count();

        if ($emailCount > 0) {
            throw new ValidationException(['email' => array('Email already Taken!')]);
        }
    }

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
            "INSERT INTO users (email, password, first_name, last_name, actual_rank, number_rank, serial_number, position)
            VALUES (:email,:password,:first_name,:last_name,:actual_rank,:number_rank,:serial_number,:position)",
            [
                'email' => $form['email'],
                'password' => $password,
                'first_name' => $form['firstName'],
                'last_name' => $form['lastName'],
                'actual_rank' => $actual_rank,
                'number_rank' => $form['rank'],
                'serial_number' => $form['serialNumber'],
                'position' => $form['position']
            ]
        );

        session_regenerate_id();

        $_SESSION['user'] = $this->db->id();
    }

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

        $_SESSION['user'] = $user['id'];
    }

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
