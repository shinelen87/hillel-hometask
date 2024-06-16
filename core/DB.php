<?php

namespace Core;

use PDO;
use Dotenv\Dotenv;

if (!defined('BASE_DIR')) {
    define('BASE_DIR', dirname(__DIR__));
}

class DB
{
    static protected PDO|null $instance = null;

    static public function connect(): PDO
    {
        if (is_null(static::$instance)) {
            $dotenv = Dotenv::createImmutable(BASE_DIR);
            $dotenv->load();

            $dsn = 'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'];
            $options = [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ];

            static::$instance = new PDO(
                $dsn,
                $_ENV['DB_USER'],
                $_ENV['DB_PASSWORD'],
                $options
            );
        }

        return static::$instance;
    }
}
