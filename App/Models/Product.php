<?php

namespace App\Models;

use Core\Model;

class Product extends Model
{
    protected static ?string $tableName = 'products';

    public ?int $id = null;
    public ?string $name = null;
    public ?float $price = null;
    public ?string $unit = null;

}

