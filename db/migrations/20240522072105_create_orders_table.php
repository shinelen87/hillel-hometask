<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateOrdersTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('orders');
        $table->addColumn('driver_id', 'integer', ['signed' => false, 'null' => false])
            ->addColumn('customer_id', 'integer', ['signed' => false, 'null' => false])
            ->addColumn('start', 'text', ['null' => false])
            ->addColumn('finish', 'text', ['null' => false])
            ->addColumn('total', 'float', ['null' => false])
            ->addForeignKey('driver_id', 'drivers', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
            ->addForeignKey('customer_id', 'customers', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
            ->create();
    }
}
