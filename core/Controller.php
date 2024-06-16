<?php

namespace Core;

use App\Enums\Status;

abstract class Controller
{
    public function before(): bool
    {
        return true;
    }

    public function after(): void
    {
    }

    /**
     * @param mixed $data
     * @param int $status
     */
    protected function jsonResponse($data, int $status = Status::OK->value): void
    {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data);
        exit();
    }
}

