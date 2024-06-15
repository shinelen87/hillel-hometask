<?php

namespace App\Models;

use Core\Model;
class Purchase extends Model
{
    protected static ?string $tableName = 'purchases';

    public int $id;
    public int $supplier_id;
    public int $product_id;
    public int $quantity;
    public string $date;
}
