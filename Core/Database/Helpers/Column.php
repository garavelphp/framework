<?php

namespace Core\Database\Helpers;

class Column
{
    public string $name;
    public string $type;

    public static function name($name): static
    {
        $static = new static();
        $static->name = $name;
        return $static;

    }
    public function autoIncrement(): static
    {
        $this->type = 'SERIAL';
        return $this;
    }

    public function primary(): static
    {
        $this->type .= ' PRIMARY KEY';
        return $this;
    }

    public function string($length = 255): static
    {
        $this->type = "VARCHAR($length)";
        return $this;
    }

    public function integer(): static
    {
        $this->type = "INTEGER";
        return $this;
    }

    public function timestamp(): static
    {
        $this->type = "TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
        return $this;
    }


}