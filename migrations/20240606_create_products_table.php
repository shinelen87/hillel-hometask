<?php

return new class {
    public function up(): string
    {
        return "
            CREATE TABLE IF NOT EXISTS products (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(30) NOT NULL,
                price DECIMAL(10, 2) NOT NULL,
                unit VARCHAR(10) NOT NULL,
                UNIQUE INDEX (id)
            ) ENGINE=INNODB;
        ";
    }

    public function down(): string
    {
        return "DROP TABLE IF EXISTS products;";
    }
};
