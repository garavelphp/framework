<?php

namespace Core\Commands\SystemCommands\Make;

use Core\Commands\Base\BaseCommand;

class MakeMigration extends BaseCommand
{

    /**
     * Your command signature
     * @var string Command signature
     */
    public $signature = 'make:migration {name}';

    /**
     * Your command description
     * @var string Command description
     */
    public $description = 'Create a new migration';

    /**
     * Your command handler
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        $name = $this->option('name');
        $name = ucfirst($name);
        $name = str_replace(' ', '', $name);
        $name = str_replace(':', '', $name);
        $name = $name . 'Command';
        $path = 'Commands/' . $name . '.php';
        $openTemplate = fopen(core_path('FileTemplates/migration.template'), 'r');
        $content = fread($openTemplate, filesize(core_path('FileTemplates/command.template')));
        $content = str_replace('[CommandName]', $name, $content);
        $createCommand = fopen(app_path($path), 'w');
        fwrite($createCommand, $content);
        fclose($createCommand);
        echo 'Command created successfully';
    }


}