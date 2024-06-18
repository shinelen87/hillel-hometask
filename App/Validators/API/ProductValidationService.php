<?php

namespace App\Validators\API;

use App\Enums\SQL;
use App\Models\Product;
use App\Validators\Base;

class ProductValidationService extends Base
{
    static protected array $errors = [];

    static public function validate(array $fields = []): bool
    {
        $result = [
            self::validateIsString($fields['name'] ?? null, 'name'),
            self::validateStringCharacters($fields['name'] ?? null, 'name'),
            self::validateIsUniqueName($fields['name'] ?? null, $fields['id'] ?? null),
            self::validateIsString($fields['unit'] ?? null, 'unit'),
        ];

        if (isset($fields['price'])) {
            $result[] = self::validateIsNumber($fields['price'], 'price');
        }

        return !in_array(false, $result, true);
    }

    static public function validateId($id): bool
    {
        self::validateIsInt($id, 'id');
        return empty(self::getErrors());
    }

    static public function validateIsUniqueName($name, $id = null): bool
    {
        $query = Product::select()->where('name', SQL::EQUAL, $name);

        if ($id) {
            $query = $query->andWhere('id', SQL::NOT_EQUAL, $id);
        }

        $result = $query->get();

        if ($result) {
            self::setError('name', "The field 'name' must be unique.");
        }

        return empty(self::getErrors());
    }

    static public function validateProductExists($id): bool
    {
        $product = Product::findById($id);
        if (!$product) {
            self::setError('id', "Product not found");
        }

        return empty(self::getErrors());
    }
}
