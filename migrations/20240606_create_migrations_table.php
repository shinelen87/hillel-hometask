<?php

namespace Migrations;

class CreateMigrationsTable {
    public function up() {
        return "
            CREATE TABLE IF NOT EXISTS migrations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                migration VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=INNODB;
        ";
    }

    public function down() {
        return "DROP TABLE IF EXISTS migrations;";
    }
}
