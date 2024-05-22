<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateDriversTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('drivers');
        $table->addColumn('car_id', 'integer', ['signed' => false, 'null' => false])
            ->addColumn('name', 'string', ['null' => false])
            ->addColumn('phone', 'string', ['null' => true])
            ->addForeignKey('car_id', 'cars', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
            ->create();
    }
}
