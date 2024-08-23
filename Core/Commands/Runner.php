<?php

namespace Core\Commands;

use JetBrains\PhpStorm\NoReturn;

class Runner
{
    public $commands = [];

    #[NoReturn] public function __construct($argv = null,$options = null)
    {

        $runStatus = 0;
        $this->loadSystemCommands();
        $this->loadCustomCommands();
        $command = $this->findCommand($argv);
        if ($command) {
            try {
                $runStatus = $command->run($options);
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
            echo "\n";
        } else {
            echo "Command not found\n";
            echo $argv . "\n";
        }
        if ($runStatus !== 0) {
            exit($runStatus);
        }

        exit(0);
    }


    public function findCommand($command_signature)
    {
        if (isset($this->commands[$command_signature])) {
            return $this->commands[$command_signature];
        }
        return null;
    }

    public function loadCustomCommands(): void
    {
        $commandsPath = app_path('Commands/');
        $this->loadCommands($commandsPath,'App\\Commands\\' );
    }

    public function loadSystemCommands(): void
    {
        $commandsPath = core_path('Commands/SystemCommands/');
        $this->loadCommands($commandsPath,'Core\\Commands\\SystemCommands\\' );
    }

    public function loadCommands($commandsPath,$namespace): void
    {
        $files = scandir($commandsPath);
        foreach ($files as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            if (is_dir($commandsPath . $file)) {
                $this->loadCommands($commandsPath . $file . '/', $namespace . $file . '\\');
                continue;
            }
            $commandFile = require_once $commandsPath . $file;
            $callClass = $namespace. str_replace('.php', '', $file);
            $command = new $callClass;
            $signature = $command->signature;
            $signature = explode(' ', $signature);
            $signature = $signature[0];
            $this->commands[$signature] = $command;
        }
    }

    public function getCommands()
    {
        return $this->commands;
    }

}