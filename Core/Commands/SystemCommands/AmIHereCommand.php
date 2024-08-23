<?php

namespace Core\Commands\SystemCommands;

class AmIHereCommand
{

    public $signature = 'am-i-here';


    public function run()
    {
        echo 'Yes, you are here';
    }

}