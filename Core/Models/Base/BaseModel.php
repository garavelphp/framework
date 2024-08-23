<?php

namespace Core\Models\Base;

use Core\Database\Queries\QueryBuilder;
use Core\Models\Traits\RelationsTrait;

class BaseModel extends QueryBuilder
{

    use RelationsTrait;

    public $exist = false;

    public array $shouldFill = [];

    public array $attributes = [];




    public function __construct()
    {
        parent::__construct();
        $this->table = $this->table ?? $this->getTableName();
        $this->select();
    }

    public function getTableName(): string
    {
        //get user model class name
        $getClassName = get_class($this);
        $getClassName = str_replace('Model', '', $getClassName);
        return strtolower($getClassName) . 's';
    }

    public function find($id): bool|array|null|BaseModel
    {

        $queryResult = $this->select()->where('id', '=', $id)->first();
        if ($queryResult){
            $this->exist = true;
            foreach ($queryResult as $key => $value) {
                $this->setAttribute($key,$value);
            }
            return $this;
        }
        return false;
    }


    public function setAttribute($key, $value): void
    {
        $this->attributes[$key] = $value;
    }

    public function save(): self
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

        if (empty($this->shouldFill)) {
            return array_filter($this->attributes, function ($key) {
                return !in_array($key, $this->shouldBeRemoveObjects());
            }, ARRAY_FILTER_USE_KEY);
        }
        return array_filter($this->attributes, function ($key) {
            return in_array($key, $this->fillable);
        }, ARRAY_FILTER_USE_KEY);

    }

    public function shouldBeRemoveObjects(): array
    {
        return ['database', 'table', 'query_string', 'exist', 'shouldFill','timerStart','timerEnd','attributes'];
    }

    public function __get($name)
    {
        return $this->attributes[$name] ?? null;
    }

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }


}