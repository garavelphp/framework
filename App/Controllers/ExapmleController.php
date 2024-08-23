<?php

namespace App\Controllers;

use Core\Controllers\BaseController;

class ExapmleController extends BaseController
{

    protected $prefix = '/';


    public function getHaello($params=[])
    {
        return 'hello world';
    }

}