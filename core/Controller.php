<?php

namespace Core;

use App\Enums\Status;
use Dotenv\Dotenv;

if (!defined('BASE_DIR')) {
    define('BASE_DIR', dirname(__DIR__));
}

abstract class Controller
{
    protected string $secretKey;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(BASE_DIR);
        $dotenv->load();

        $this->secretKey = $_ENV['JWT_SECRET'];
    }

    public function before(string $action, array $params = []): bool
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

