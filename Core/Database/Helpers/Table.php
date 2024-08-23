<?php

namespace Core\Database\Helpers;

class Table
{

    public string $name;
    public array $columns = [];
    public bool $shouldDrop = false;

    public static function name(string $name): static
    {
        $static = new static();
        $static->name = $name;
        return $static;
    }

    public function column(Column $column): static
    {
        $this->columns[] = $column;
        return $this;
    }

    public function addColumn(Column $column): static
    {
        $this->columns[] = $column;
        return $this;
    }

    public function removeColumn(Column $column): static
    {

        foreach ($this->columns as $key => $col) {
            if ($col->name == $column->name) {
                unset($this->columns[$key]);
            }
        }
        return $this;

    }

    public function dropTable(): static
    {
        $this->shouldDrop = true;
        return $this;
    }

}