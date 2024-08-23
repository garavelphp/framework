<?php

namespace App\Models;

use Core\Models\Base\BaseModel;

class UserModel extends BaseModel
{

    public $table = 'users';



    public function getIdentifyMany()
    {
       return $this->hasMany($this,UserIdentifyModel::class, 'user_id', 'id');
    }

    public function getIdentifyOne()
    {
        return $this->hasMany($this,UserIdentifyModel::class, 'user_id', 'id');
    }

}