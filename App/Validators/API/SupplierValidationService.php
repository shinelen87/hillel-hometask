<?php

namespace App\Validators\API;

use App\Models\Supplier;
use App\Validators\Base;
use App\Enums\SQL;

class SupplierValidationService extends Base
{
    static protected array $errors = [];

    static public function validate(array $fields = []): bool
    {
        $result = [
            self::validateIsString($fields['name'] ?? null, 'name'),
            self::validateStringCharacters($fields['name'] ?? null, 'name'),
            self::validateIsUniqueName($fields['name'] ?? null, $fields['id'] ?? null),
            !isset($fields['address']) || self::validateIsString($fields['address'], 'address'),
            !isset($fields['phone']) || self::validateIsString($fields['phone'], 'phone')
        ];

        return !in_array(false, $result, true);
    }

    static public function validateId($id): bool
    {
        self::validateIsInt($id, 'id');
        return empty(self::getErrors());
    }

    static public function validateIsUniqueName($name, $id = null): bool
    {
        $query = Supplier::select()->where('name', SQL::EQUAL, $name);

        if ($id) {
            $query = $query->andWhere('id', SQL::NOT_EQUAL, $id);
        }

        $result = $query->get();

        if ($result) {
            self::setError('name', "The field 'name' must be unique.");
        }

        return empty(self::getErrors());
    }

    static public function validateSupplierExists($id): bool
    {
        $supplier = Supplier::findById($id);
        if (!$supplier) {
            self::setError('id', "Supplier not found");
        }

        return empty(self::getErrors());
    }

    public static function validateRequiredFields(array $fields, array $requiredFields): bool
    {
        foreach ($requiredFields as $field) {
            if (!self::validateRequired($fields, $field)) {
                return false;
            }
        }
        return true;
    }
}
