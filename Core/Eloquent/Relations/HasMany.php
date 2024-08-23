<?php

namespace Core\Eloquent\Relations;

use Core\Models\Base\BaseModel;

class HasMany
{

    public BaseModel $model;
    public $modelTarget;
    public string $target_column;
    public string $local_column;
    public function __construct(BaseModel $model, $modelTarget, string $target_column, string $local_column)
    {
        $this->model = $model;
        $this->modelTarget = new $modelTarget;
        $this->target_column = $target_column;
        $this->local_column = $local_column;
    }

    public function get(): BaseModel|array|null
    {
        return $this->modelTarget->select()->where($this->target_column,'=', $this->model->{$this->local_column})->get();
    }
}