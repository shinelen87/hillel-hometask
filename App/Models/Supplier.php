<?php

namespace App\Models;

use Core\Model;
class Supplier extends Model
{
    protected static ?string $tableName = 'suppliers';

    public int $id;
    public string $name;
    public ?string $address;
    public ?string $phone;
}
