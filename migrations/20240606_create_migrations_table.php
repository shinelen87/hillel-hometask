<?php

return new class {
    public function up(): string
    {
        return "
            CREATE TABLE IF NOT EXISTS migrations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                migration VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=INNODB;
        ";
    }

    public function down(): string
    {
        return "DROP TABLE IF EXISTS migrations;";
    }
};

