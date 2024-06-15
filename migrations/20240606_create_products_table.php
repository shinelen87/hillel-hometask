<?php

return new class {
    public function up(): string
    {
        return "
            CREATE TABLE IF NOT EXISTS products (
                product_name VARCHAR(30) NOT NULL,
                price DECIMAL(10, 2) NOT NULL,
                unit VARCHAR(10) NOT NULL,
                PRIMARY KEY (product_name),
                UNIQUE INDEX (product_name)
            ) ENGINE=INNODB;
        ";
    }

    public function down(): string
    {
        return "DROP TABLE IF EXISTS products;";
    }
};
