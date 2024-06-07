<?php

namespace migrations;

class CreatePurchasesTable {
    public function up(): string
    {
        return "
            CREATE TABLE IF NOT EXISTS purchases (
                supplier_name VARCHAR(30) NOT NULL,
                product_name VARCHAR(30) NOT NULL,
                quantity INT NOT NULL,
                date DATE NOT NULL,
                FOREIGN KEY (supplier_name) REFERENCES suppliers(supplier_name),
                FOREIGN KEY (product_name) REFERENCES products(product_name)
            ) ENGINE=INNODB;
        ";
    }

    public function down(): string
    {
        return "DROP TABLE IF EXISTS purchases;";
    }
}

