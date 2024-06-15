<?php

namespace App\Models;

use Overload\Exceptions\InvalidMethodException;

class User {
    private string $name;
    private int $age;
    private string $email;

    /**
     * @throws InvalidMethodException
     */
    public function __call(string $name, $arguments) {
        if (!method_exists($this, $name)) {
            throw new InvalidMethodException("Method $name does not exist.\n");
        }
        call_user_func_array([$this, $name], $arguments);
    }

    private function setName(string $name): void
    {
        $this->name = $name;
    }

    private function setAge(string $age): void
    {
        $this->age = $age;
    }

    private function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getAll(): array
    {
        return [
            'name' => $this->name,
            'age' => $this->age,
            'email' => $this->email
        ];
    }
}
