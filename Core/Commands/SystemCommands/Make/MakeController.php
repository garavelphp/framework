<?php

namespace Core\Commands\SystemCommands\Make;

use Core\Commands\Base\BaseCommand;

class MakeController extends BaseCommand
{

    /**
     * Your command signature
     * @var string Command signature
     */
    public $signature = 'make:controller {name} {prefix}';

    /**
     * Your command description
     * @var string Command description
     */
    public $description = 'Create a new controller';

    /**
     * Your command handler
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        $name = $this->option('name');
        if (str_contains($name, '/')) {
            $explode = explode('/', $name);
            $className = $explode[count($explode) - 1];
            $nameSpace = '';
            foreach ($explode as $key => $value) {
                if ($key == count($explode) - 1) {
                    break;
                }
                $nameSpace .= $value . '\\';
            }
            $nameSpace = rtrim($nameSpace, '\\');
            $nameSpace = 'namespace App\Controllers\\' . $nameSpace . ';';
            $nameSpace = str_replace('/', '', $nameSpace);
            $nameSpace = str_replace('\\\\', '\\', $nameSpace);
            $nameSpace = str_replace('Controllers\\Controllers', 'Controllers', $nameSpace);
        } else {
            $nameSpace = 'namespace App\Controllers;';
            $className = $name;
        }
        $prefix = $this->option('prefix');
        $name = $this->cleanName($name);
        $className = $this->cleanName($className);
        $path = 'Controllers/' . $name . '.php';
        $content = $this->getTemplateContent(core_path('FileTemplates/controller.template'));
        $content = $this->changeContent('[Namespace]', $nameSpace, $content);
        $content = $this->changeContent('[NameSpace]', $className, $content);
        $content = $this->changeContent('[ControllerName]', $className, $content);
        $content = $this->changeContent('[prefix]', $prefix, $content);
        $this->createFile($path, $content);
        echo 'Controller created successfully';
    }

}