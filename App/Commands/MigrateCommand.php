<?php

namespace App\Commands;

use splitbrain\phpcli\CLI;
use splitbrain\phpcli\Options;
use Core\DB;

class MigrateCommand extends CLI
{
    protected const DEFAULT_MIGRATION = '20240606_create_migrations_table';
    protected function setup(Options $options): void
    {
        $options->setHelp('Database migration command');
        $options->registerOption('action', 'The migration action to perform (up, down)', 'a', 'action');
    }

    protected function main(Options $options): void
    {
        $action = $options->getOpt('action');
        $migrations = $this->loadMigrations();

        $pdo = DB::connect();

        if ($action === 'up') {
            $pdo->exec($migrations[self::DEFAULT_MIGRATION]->up());

            $executedMigrations = $pdo->query("SELECT migration FROM migrations")->fetchAll(\PDO::FETCH_COLUMN);
            foreach ($migrations as $migrationName => $migration) {
                if (!in_array($migrationName, $executedMigrations)) {
                    $query = $migration->up();
                    $pdo->exec($query);
                    $stmt = $pdo->prepare("INSERT INTO migrations (migration) VALUES (:migration)");
                    $stmt->execute(['migration' => $migrationName]);
                    $this->info("Migration up: " . $migrationName);
                }
            }
        } elseif ($action === 'down') {
            foreach (array_reverse($migrations) as $migrationName => $migration) {
                if ($migrationName === self::DEFAULT_MIGRATION) {
                    continue;
                }
                
                $query = $migration->down();
                $pdo->exec($query);
                $stmt = $pdo->prepare("DELETE FROM migrations WHERE migration = :migration");
                $stmt->execute(['migration' => $migrationName]);
                $this->info("Migration down: " . $migrationName);
            }
        } else {
            $this->error("Unknown action: $action");
            $this->info("Usage: php migrate.php --action [up|down]");
            exit(1);
        }
    }

    private function loadMigrations(): array
    {
        $files = glob(__DIR__ . '/../../migrations/*.php');
        $migrations = [];

        foreach ($files as $file) {
            $migration = include $file;
            $migrationName = basename($file, '.php');
            $migrations[$migrationName] = $migration;
        }

        return $migrations;
    }
}
