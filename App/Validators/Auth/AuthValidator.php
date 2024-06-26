<?php

namespace App\Validators\Auth;

use App\Validators\Base;

class AuthValidator extends Base
{
    const DEFAULT_MESSAGE = 'Email or password is incorrect';
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
            self::validatePassword($fields['password'] ?? null),
            static::checkEmailOnExists($fields['email'], false, self::DEFAULT_MESSAGE)
        ];

        return !in_array(false, $result);
    }
}

