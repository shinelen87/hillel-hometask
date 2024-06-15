<?php

namespace Core;

use Core\Traits\Queryable;

abstract class Model
{
    use Queryable;

    public ?int $id;

    public function toArray(): array
    {
        $data = [];

        $reflect = new \ReflectionClass($this);
        $props = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC);
        $vars = (array) $this;

        foreach($props as $prop) {
            if (in_array($prop->getName(), ['commands', 'tableName'])) {
                continue;
            }

            $data[$prop->getName()] = $vars[$prop->getName()] ?? null;
        }

        return $data;
    }
}
