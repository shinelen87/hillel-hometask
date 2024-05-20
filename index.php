<?php

require 'vendor/autoload.php';

use Overload\Models\User;
use Overload\Exceptions\InvalidMethodException;

$user = new User();

try {
    $user->setName("John Doe");
    $user->setAge(30);
    $user->setEmail("john.doe@example.com");
    $user->setAddress("123 Main St");
} catch (InvalidMethodException $e) {
    echo $e->getMessage();
}

print_r($user->getAll());
