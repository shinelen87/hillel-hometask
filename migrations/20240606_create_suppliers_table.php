<?php

return new class {
    public function up(): string
    {
        return "
            CREATE TABLE IF NOT EXISTS suppliers (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(30) NOT NULL,
                address VARCHAR(50),
                phone VARCHAR(16),
                UNIQUE INDEX (id)
            ) ENGINE=INNODB;
        ";
    }

    public function down(): string
    {
        return "DROP TABLE IF EXISTS suppliers;";
    }
};

