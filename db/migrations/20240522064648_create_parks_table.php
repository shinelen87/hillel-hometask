<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateParksTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('parks');
        $table->addColumn('address', 'string', ['limit' => 255, 'null' => false])
            ->create();
    }
}
