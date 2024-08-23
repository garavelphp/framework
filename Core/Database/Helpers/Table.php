<?php

namespace Core\Database\Helpers;

class Table
{

    public $name;
    public $columns = [];
    public $shouldDrop = false;

    public static function name($name)
    {
        $static = new static();
        $static->name = $name;
        return $static;
    }

    public function column(Column $column)
    {
        $this->columns[] = $column;
        return $this;
    }

    public function addColumn(Column $column)
    {
        $this->columns[] = $column;
        return $this;
    }

    public function removeColumn(Column $column)
    {

        foreach ($this->columns as $key => $col) {
            if ($col->name == $column->name) {
                unset($this->columns[$key]);
            }
        }
        return $this;

    }

    public function dropTable()
    {
        $this->shouldDrop = true;
        return $this;
    }

}