<?php

namespace Core\Commands\SystemCommands\Run;

use Core\Commands\Base\BaseCommand;

class RunMigrationCommand extends BaseCommand
{

    /**
     * Your command signature
     * @var string Command signature
     */
    public $signature = 'migration:run {name} {type}';

    /**
     * Your command description
     * @var string Command description
     */
    public $description = 'Run migration';

    /**
     * Your command handler
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        $name = $this->option('name');
        $type = $this->option('type');

        if (!file_exists(app_path('Database/Migrations/' . $name . '.php'))) {
            throw new \Exception('Migration not found');
        }

        $migration = 'App\\Database\\Migrations\\' . $name;
        $migration = new $migration();
        $migration->run($type);
    }


}