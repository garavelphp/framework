<?php

namespace App\Commands;

use App\Models\UserModel;
use Core\Commands\Base\BaseCommand;

class TestCodeCommandCommand extends BaseCommand
{

    /**
     * Your command signature
     * @var string Command signature
     */
    public $signature = 'test-code';

    /**
     * Your command description
     * @var string Command description
     */
    public $description = 'Your command description';

    /**
     * Your command handler
     * @return void
     */
    public function run()
    {
        $user = (new \App\Models\UserModel)->find(5);
        echo json_encode($user);
    }

}

