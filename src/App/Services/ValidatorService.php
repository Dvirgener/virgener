<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Validator;
use Framework\Rules\{RequiredRule, EmailRule, MinRule, InRule, URLRule, PasswordMatchRule, LengthMaxRule, NumericRule, DateFormatRule};

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
        $this->validator->add('maxLength', new LengthMaxRule());
        $this->validator->add('numeric', new NumericRule());
        $this->validator->add('dateFormat', new DateFormatRule());
    }

    public function validateRegister(array $formData)
    {
        $this->validator->validate($formData, [
            'firstName' => ['required'],
            'email' => ['required','email'],
            'password' => ['required','password'],
            'confirmPassword' => ['required','password'],
            'lastName' => ['required'],
            'rank' => ['required','in:1,2,3,4,5,6,7,8,9,10,11,12'],
            'position' => ['required','in:OIC,Assistant OIC,NCOIC,Personnel'],
            'serialNumber' => ['required','numeric']
            // 'age' => ['required', 'min:18'],
            // 'country' => ['required', 'in:USA,Canada,Mexico'],
            // 'socialMediaURL' => ['required', 'url'],
            // 'password' => ['required', 'password'],
            // 'confirmPassword' => ['required', 'password'],
            // 'tos' => ['required']

        ]);
    }

    public function validateLogin(array $formData)
    {
        $this->validator->validate(
            $formData,
            [
                'email' => ['required', 'email'],
                'password' => ['required']
            ]
        );
    }

    public function validateTransaction(array $formData)
    {
        $this->validator->validate(
            $formData,
            [
                'description' => ['required', 'maxLength:255'],
                'amount' => ['required', 'numeric'],
                'date' => ['required', 'dateFormat:Y-m-d']
            ]
        );
    }
}
