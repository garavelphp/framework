<?php

namespace Core\Models\Base;

use Core\Database\Queries\QueryBuilder;

class BaseModel extends QueryBuilder
{

    public $exist = false;

    public $shouldFill = [];

    public $attributes = [];

    public function __construct()
    {
        parent::__construct();
        $this->table = $this->table ?? $this->getTableName();
    }

    public function getTableName()
    {
        //get user model class name
        $getClassName = get_class($this);
        $getClassName = str_replace('Model', '', $getClassName);
        return strtolower($getClassName) . 's';
    }

    public static function find($id)
    {
        $static = new static;
        $queryResult = $static->select()->where('id', '=', $id)->first();

        if ($queryResult){
            $static->exist = true;
            foreach ($queryResult as $key => $value) {
                $static->setAttribute($key,$value);
            }
            return $static->result($queryResult);
        }
        return false;
    }

    public function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    public function save()
    {
        if ($this->exist) {
            $this->where('id', $this->id)->update($this->getAttributes());
        } else {
            $insert = $this->insert($this->getAttributes());
            if ($insert) {
                $this->exist = true;
            }
            $this->id = $insert['id'];
        }
        return $this;
    }

    public function getAttributes(): array
    {
        $allObjects = get_object_vars($this);
        if (empty($this->shouldFill)) {
            return array_filter($allObjects, function ($key) {
                return !in_array($key, $this->shouldBeRemoveObjects());
            }, ARRAY_FILTER_USE_KEY);
        }
        return array_filter($allObjects, function ($key) {
            return in_array($key, $this->fillable);
        }, ARRAY_FILTER_USE_KEY);

    }

    public function shouldBeRemoveObjects()
    {
        return ['database', 'table', 'query_string', 'exist', 'shouldFill'];
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }


}