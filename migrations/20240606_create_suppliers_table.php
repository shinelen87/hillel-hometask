<?php

namespace Migrations;

class CreateSuppliersTable {
    public function up(): string
    {
        return "
            CREATE TABLE IF NOT EXISTS suppliers (
                supplier_name VARCHAR(30) NOT NULL,
                address VARCHAR(50),
                phone VARCHAR(16),
                PRIMARY KEY (supplier_name),
                UNIQUE INDEX (supplier_name)
            ) ENGINE=INNODB;
        ";
    }

    public function down(): string
    {
        return "DROP TABLE IF EXISTS suppliers;";
    }
}

