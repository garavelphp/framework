<?php

namespace App\Models;

use Core\Models\Base\BaseModel;

class UserModel extends BaseModel
{

    public $table = 'users';

    /**
     * @return array|BaseModel|null
     */
    public function getIdentifyMany(): array|BaseModel|null
    {
       return $this->hasMany(model: $this,modelTarget: UserIdentifyModel::class, foreign_column: 'user_id', local_column: 'id');
    }

    /**
     * @return array|BaseModel|null
     */
    public function getIdentifyOne(): array|BaseModel|null
    {
        return $this->hasOne(model: $this,modelTarget: UserIdentifyModel::class, foreign_column: 'user_id', local_column: 'id');
    }

}














