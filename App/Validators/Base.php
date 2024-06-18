<?php

namespace App\Validators;

use App\Models\User;

abstract class Base extends BaseValidator
{
    static protected array $rules = [
        'email' => '/^[a-zA-Z0-9.!#$%&\'*+\/\?^_`{|}~-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i',
        'password' => '/[a-zA-Z0-9.!#$%&\'*+\/\?^_`{|}~-]{8,}/',
    ];

    static public function checkEmailOnExists(string $email, bool $eqError = true, string $message = 'Email already exists'): bool
    {
        $result = (bool) User::findBy('email', $email);

        if ($result === $eqError) {
            static::setError('email', $message);
        }

        return $result;
    }

    static public function validateIsInt($fieldValue, $fieldName): bool
    {
        if (!preg_match('/^\d+$/', (string)$fieldValue)) {
            self::setError($fieldName, "The field '{$fieldName}' must be an integer.");
            return false;
        }
        return true;
    }

    static public function validateIsNumber($fieldValue, $fieldName): bool
    {
        if (!is_numeric($fieldValue) || $fieldValue <= 0) {
            self::setError($fieldName, "The field '{$fieldName}' must be a positive number.");
            return false;
        }
        return true;
    }

    static public function validateIsString($fieldValue, $fieldName): bool
    {
        if (!is_string($fieldValue)) {
            self::setError($fieldName, "The field '{$fieldName}' must be a string.");
            return false;
        }
        return true;
    }

    static public function validateStringCharacters($fieldValue, $fieldName): bool
    {
        if (!preg_match('/[\w\s\(\)\-]{3,}/i', $fieldValue)) {
            self::setError($fieldName, "The field '{$fieldName}' contains invalid characters or is too short.");
            return false;
        }
        return true;
    }

    static protected function validateRequired(array $data, string $field): bool
    {
        if (!isset($data[$field])) {
            self::setError($field, "The field '{$field}' is required.");
            return false;
        }
        return true;
    }

    static public function validateRequiredFields(array $fields, array $requiredFields): bool
    {
        foreach ($requiredFields as $field) {
            if (!self::validateRequired($fields, $field)) {
                return false;
            }
        }
        return true;
    }


    static protected function validateIsUniqueUsername($username): bool
    {
        $result = (bool) User::findBy('username', $username);
        if ($result) {
            self::setError('username', "The field 'username' must be unique.");
        }
        return !$result;
    }

    static protected function validateIsUniqueEmail($email): bool
    {
        $result = (bool) User::findBy('email', $email);
        if ($result) {
            self::setError('email', "The field 'email' must be unique.");
        }
        return !$result;
    }

    static protected function validatePassword($password): bool
    {
        if (!preg_match('/[a-zA-Z0-9.!#$%&\'*+\/\?^_`{|}~-]{8,}/', $password)) {
            self::setError('password', "Password is incorrect. Minimum length is 8 symbols.");
            return false;
        }
        return true;
    }
}
