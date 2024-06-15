<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateCarsTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('cars');
        $table->addColumn('park_id', 'integer', ['signed' => false, 'null' => false])
            ->addColumn('model', 'string', ['null' => false])
            ->addColumn('price', 'float', ['null' => false])
            ->addForeignKey('park_id', 'parks', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
            ->create();
    }
}
