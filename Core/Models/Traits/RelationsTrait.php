<?php

namespace Core\Models\Traits;

use Core\Eloquent\Relations\HasMany;
use Core\Eloquent\Relations\HasOne;
use Core\Models\Base\BaseModel;

trait RelationsTrait
{
    public function hasOne(BaseModel $model,$modelTarget,string $foreign_column, string $local_column = 'id'): BaseModel|array|null
    {
        $result = (new HasOne($model,$modelTarget,$foreign_column,$local_column))->first();
        $relation_name = debug_backtrace()[1]['function'];
        $relation_name = convert2snakeCase($relation_name);
        $model->setAttribute($relation_name,$result);
        return $model;
    }

    public function belongsTo(BaseModel $model,$modelTarget,string $foreign_column, string $local_column = 'id'): BaseModel|array|null
    {
        $result = (new HasOne($model,$modelTarget,$foreign_column,$local_column))->first();
        $relation_name = debug_backtrace()[1]['function'];
        $relation_name = convert2snakeCase($relation_name);
        $model->setAttribute($relation_name,$result);
        return $model;
    }

    public function hasMany(BaseModel $model,$modelTarget,string $foreign_column, string $local_column = 'id'): BaseModel|array|null
    {
        $result = (new HasMany($model,$modelTarget,$foreign_column,$local_column))->first();
        $relation_name = debug_backtrace()[1]['function'];
        $relation_name = convert2snakeCase($relation_name);
        $model->setAttribute($relation_name,$result);
        return $model;
    }
}