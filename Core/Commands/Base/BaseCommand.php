<?php

namespace Core\Commands\Base;

use Core\Commands\Helpers\ConsoleTable;

class BaseCommand implements IBaseCommandInterface
{

    public $options;

    public function __construct()
    {
        $this->getOptions();
    }

    public function run()
    {
        // TODO: Implement run() method.
    }

    public function option($key)
    {
        global $argv;
        $optionKey = array_search($key, $this->options);
        if ($optionKey === false) {
            throw new \Exception('Argument not found : ' . $key);
        }
        if (isset($argv[$optionKey + 2])) {
            return $argv[$optionKey + 2];
        }
        return null;
    }

    public function getOptions()
    {
        $signature = $this->signature;
        $signature = explode(' ', $signature);
        $options = [];
        foreach ($signature as $key => $value) {
            if (strpos($value, '{') !== false) {
                $value = str_replace('{', '', $value);
                $value = str_replace('}', '', $value);
                $options[] = $value;
            }
        }
        $this->options = $options;
        return $options;
    }


    public function createFile($path, $content)
    {
        $this->dirCheck($path);
        $createCommand = fopen(app_path($path), 'w');
        fwrite($createCommand, $content);
        fclose($createCommand);
        chmod(app_path($path), 0777);
    }

    public function getTemplateContent($path)
    {
        $openTemplate = fopen($path, 'r');
        $content = fread($openTemplate, filesize($path));
        return $content;
    }

    public function changeContent($key, $value, $content)
    {
        return str_replace($key, $value, $content);
    }

    public function cleanName($name)
    {
        $name = ucfirst($name);
        $name = str_replace(' ', '', $name);
        $name = str_replace(':', '', $name);
        return $name;
    }


    public function dirCheck($path)
    {

        $path = str_replace('\\', '/', $path);
        $path = pathinfo($path)['dirname'];
        if (!file_exists(app_path($path))){
            mkdir(app_path($path), 0777, true);

        }
    }

    public function table($header, $data)
    {
        $table = new ConsoleTable();
        $table->setHeaders($header);
        $table->addRows($data);
        $table->display();
    }
}