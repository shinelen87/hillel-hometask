<?php

namespace Core;

abstract class Controller
{
    public function before()
    {
    }

    public function after()
    {
    }

    protected function jsonResponse($data, int $status = 200): void
    {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data);
        exit();
    }
}

