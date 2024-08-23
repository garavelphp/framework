<?php

namespace Core\Database\Helpers;

class Column
{
    public $name;
    public $type;

    public static function name($name)
    {
        $static = new static();
        $static->name = $name;
        return $static;

    }
    public function autoIncrement()
    {
        $this->type = 'SERIAL';
        return $this;
    }

    public function primary()
    {
        $this->type .= ' PRIMARY KEY';
        return $this;
    }

    public function string($length = 255)
    {
        $this->type = "VARCHAR($length)";
        return $this;
    }

    public function integer()
    {
        $this->type = "INTEGER";
        return $this;
    }

    public function timestamp()
    {
        $this->type = "TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
        return $this;
    }


}