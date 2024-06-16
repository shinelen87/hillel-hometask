<?php

namespace App\Models;

use Core\Model;

class User extends Model
{
    protected static ?string $tableName = 'users';

    public ?int $id = null;
    public ?string $username = null;
    public ?string $email = null;
    public ?string $password = null;
    public ?string $created_at = null;
    public ?string $updated_at = null;
}
