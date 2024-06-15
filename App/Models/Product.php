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

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function fill(array $data): self
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
        return $this;
    }
}

