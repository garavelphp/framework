<?php

namespace App\Controllers;

use Core\Controllers\BaseController;

class HomeController extends BaseController
{

    protected $prefix = '/';


    public function getHello($params=[])
    {
        echo 'controller işçi';
    }

}