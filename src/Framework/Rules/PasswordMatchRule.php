<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;
use InvalidArgumentException;

class PasswordMatchRule implements RuleInterface
{
    public function validate(array $formData, string $field, array $params): bool
    {
        return $formData['password'] === $formData['confirmPassword'];
    }

    public function getMessage(array $formData, string $field, array $params): string
    {
        return "Password Didn't Match";
    }
}
