<?php

namespace Core\Traits;

use Core\DB;
use App\Enums\SQL;
use PDO;

trait Queryable
{
    protected array $selectColumns = ['*'];
    protected array $whereConditions = [];
    protected array $bindings = [];

    protected ?string $groupBy = null;

    public static function select(array $columns = ['*']): self
    {
        $instance = new static();
        $instance->selectColumns = $columns;
        return $instance;
    }

    public function where(string $column, SQL $operator, $value): self
    {
        $this->whereConditions[] = "{$column} {$operator->value} ?";
        $this->bindings[] = $value;
        return $this;
    }

    public function andWhere(string $column, SQL $operator, $value): self
    {
        $this->whereConditions[] = "AND {$column} {$operator->value} ?";
        $this->bindings[] = $value;
        return $this;
    }

    public function orWhere(string $column, SQL $operator, $value): self
    {
        $this->whereConditions[] = "OR {$column} {$operator->value} ?";
        $this->bindings[] = $value;
        return $this;
    }

    public function groupBy(string $column): self
    {
        $this->groupBy = "GROUP BY {$column}";
        return $this;
    }

    public function get(): array
    {
        $query = "SELECT " . implode(', ', $this->selectColumns) . " FROM {$this->getTableName()}";
        if (!empty($this->whereConditions)) {
            $query .= " WHERE " . implode(' ', $this->whereConditions);
        }
        if (!empty($this->groupBy)) {
            $query .= " " . $this->groupBy;
        }

        $stmt = $this->query($query, $this->bindings);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function query(string $query, array $bindings = [])
    {
        $pdo = DB::connect();
        $stmt = $pdo->prepare($query);
        $stmt->execute($bindings);
        return $stmt;
    }

    protected function getTableName(): string
    {
        return static::$tableName ?? strtolower((new \ReflectionClass($this))->getShortName()) . 's';
    }

    public function save(): bool
    {
        $pdo = DB::connect();
        $attributes = get_object_vars($this);

        // Видалення будь-яких полів, які не є стовпцями таблиці
        $attributes = array_filter($attributes, function($key) {
            return !in_array($key, ['selectColumns', 'whereConditions', 'bindings', 'groupBy']);
        }, ARRAY_FILTER_USE_KEY);

        if ($this->id) {
            $setString = implode(', ', array_map(fn($key) => "{$key} = :{$key}", array_keys($attributes)));
            $stmt = $pdo->prepare("UPDATE {$this->getTableName()} SET {$setString} WHERE id = :id");
        } else {
            $columns = implode(', ', array_keys($attributes));
            $placeholders = implode(', ', array_map(fn($key) => ":{$key}", array_keys($attributes)));
            $stmt = $pdo->prepare("INSERT INTO {$this->getTableName()} ({$columns}) VALUES ({$placeholders})");
            if ($stmt->execute($attributes)) {
                $this->id = (int)$pdo->lastInsertId();
                return true;
            }
            return false;
        }
        return $stmt->execute($attributes);
    }

    public function delete(): bool
    {
        $pdo = DB::connect();
        $stmt = $pdo->prepare("DELETE FROM {$this->getTableName()} WHERE id = :id");
        return $stmt->execute(['id' => $this->id]);
    }

    public static function findById(int $id): ?self
    {
        $pdo = DB::connect();
        $instance = new static();
        $stmt = $pdo->prepare("SELECT * FROM " . $instance->getTableName() . " WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $instance->fill($data);
            return $instance;
        }

        return null;
    }

    public static function findBy(string $field, mixed $variable): ?self
    {
        $pdo = DB::connect();
        $instance = new static();
        $stmt = $pdo->prepare("SELECT * FROM " . $instance->getTableName() . " WHERE $field = :variable");
        $stmt->execute(['variable' => $variable]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $instance->fill($data);
            return $instance;
        }

        return null;
    }
}
