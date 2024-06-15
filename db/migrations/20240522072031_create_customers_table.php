<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateCustomersTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('customers');
        $table->addColumn('name', 'string', ['null' => false])
            ->addColumn('phone', 'string', ['null' => true])
            ->create();
    }
}
