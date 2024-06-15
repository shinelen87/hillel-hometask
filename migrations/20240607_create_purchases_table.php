<?php

return new class {
    public function up(): string
    {
        return "
            CREATE TABLE IF NOT EXISTS purchases (
                id INT AUTO_INCREMENT PRIMARY KEY,
                supplier_id INT NOT NULL,
                product_id INT NOT NULL,
                quantity INT NOT NULL,
                date DATE NOT NULL,
                UNIQUE INDEX (id),
                FOREIGN KEY (supplier_id) REFERENCES suppliers(id),
                FOREIGN KEY (product_id) REFERENCES products(id)
            ) ENGINE=INNODB;
        ";
    }

    public function down(): string
    {
        return "DROP TABLE IF EXISTS purchases;";
    }
};

