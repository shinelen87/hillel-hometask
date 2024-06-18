<?php

namespace App\Models;

use Core\Model;
class Supplier extends Model
{
    protected static ?string $tableName = 'suppliers';

    public ?int $id = null;
    public ?string $name = null;
    public ?string $address = null;
    public ?string $phone = null;
}
