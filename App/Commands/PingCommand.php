<?php

namespace App\Commands;

use Core\Commands\Base\BaseCommand;

class PingCommand extends BaseCommand
{

    /**
     * Your command signature
     * @var string Command signature
     */
    public $signature = 'ping';

    /**
     * Your command description
     * @var string Command description
     */
    public $description = 'Ping command';

    /**
     * Your command handler
     * @return void
     */
    public function run()
    {
        echo 'PONG';
    }

}

