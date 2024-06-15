<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Commands\MigrateCommand;

$cli = new MigrateCommand();
$cli->run();
