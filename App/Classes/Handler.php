<?php

namespace App\Classes;


use Core\Database\Drivers\Base\BaseDatabase;

class Handler
{

    public function terminate($callback)
    {
        try {
            $callback();
            if ($this->dbIsConnected()) {
//                $this->findAndDestroyDatabaseConnection();
            }
        } catch (\Exception $e) {
            if ($this->dbIsConnected()) {
//                $this->findAndDestroyDatabaseConnection();
            }
            $response = new Response();
            $this->log([
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            $response->error($e->getMessage(), $e->getCode())
                ->send();
        }
    }


    public function dbIsConnected(): bool
    {
        return $GLOBALS['dbIsConnected'] ?? false;
    }

    public function findAndDestroyDatabaseConnection(): void
    {
        $db = new BaseDatabase();
        $db->disconnect();
    }


    public function log($data, $file = null)
    {
        if (is_null($file)) {
            $file = $this->generateFileName();
        }
        $file = fopen($file, 'a');
        $date = date('Y-m-d H:i:s');
        $data = array_merge(['time' => "[$date]:"], $data);
        $text = '';
        foreach ($data as $key => $value) {
            $text .= $key . ' : ' . $value . PHP_EOL;
        }
        $text .= '=============================================' . PHP_EOL;
        fwrite($file, $text);
        fclose($file);
    }


    public function generateFileName(): string
    {

        $upDir = dirname(__DIR__);
        $logDir = 'Logs';
        $dates = date('Y/m/d');
        $file = 'error_logs.txt';
        $path = $upDir . '/' . $logDir . '/' . $dates . '/' . $file;
        if (!file_exists($path)) {
            mkdir(dirname($path), 0777, true);
            touch($path);
        }
        return $path;
    }

}