<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Validator;
use Framework\Rules\{RequiredRule, EmailRule, MinRule, InRule, URLRule, PasswordMatchRule};

class ValidatorService
{
    private Validator $validator;

    public function __construct()
    {
        $this->validator = new Validator();
        $this->validator->add('required', new RequiredRule());
        $this->validator->add('min', new MinRule());
        $this->validator->add('email', new EmailRule());
        $this->validator->add('in', new InRule());
        $this->validator->add('url', new URLRule());
        $this->validator->add('password', new PasswordMatchRule());
    }

    public function validateRegister(array $formData)
    {
        $this->validator->validate($formData, [
            'email' => ['required', 'email'],
            'age' => ['required', 'min:18'],
            'country' => ['required', 'in:USA,Canada,Mexico'],
            'socialMediaURL' => ['required', 'url'],
            'password' => ['required', 'password'],
            'confirmPassword' => ['required', 'password'],
            'tos' => ['required']

        ]);
    }
}
