<?php

namespace App\Validators\Auth;

use App\Models\User;
use App\Validators\Base;

class RegisterValidator extends Base
{
    static protected array $errors = [];

    static public function validate(array $fields = []): bool
    {
        $result = [
            self::validateIsString($fields['username'] ?? null, 'username'),
            self::validateIsString($fields['email'] ?? null, 'email'),
            self::validateStringCharacters($fields['username'] ?? null, 'username'),
            self::validateStringCharacters($fields['email'] ?? null, 'email'),
            self::validateIsUniqueUsername($fields['username'] ?? null),
            self::validateIsUniqueEmail($fields['email'] ?? null),
            self::validatePassword($fields['password'] ?? null)
        ];

        return !in_array(false, $result);
    }
}

