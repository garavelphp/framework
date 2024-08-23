<?php

namespace Core\Commands\SystemCommands;

use Core\Commands\Base\BaseCommand;

class AmIUpCommand extends BaseCommand
{

    public $signature = 'am-i-up';

    public function run()
    {
        $appUrl = config('app.health_check_url') ?? config('app.url');
        $ch = curl_init($appUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($httpCode == 200) {
            echo 'Yes, I am up';
        } else {
            echo 'No, I am down';
        }

    }

}