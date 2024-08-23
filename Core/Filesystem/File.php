<?php

namespace Core\Filesystem;

class File
{


    private $path;

    public function __construct($path=null)
    {
        $this->path = $path;
    }
    /**
     * @param $path
     * @return string
     * @throws \Exception
     */
    public function open($path=null): string
    {
        if (!$path && !$this->path) {
            throw new \Exception("File path is required");
        }

        $path = $path ?? $this->path;

        if (!file_exists($path)) {
            throw new \Exception("File does not exist: " . $path);
        }

        if (!is_readable($path)) {
            throw new \Exception("File is not readable: " . $path);
        }

        $stream = fopen($path, 'r');
        if ($stream === false) {
            throw new \Exception("Failed to open file: " . $path);
        }

        $content = stream_get_contents($stream);
        fclose($stream);

        if ($content === false) {
            throw new \Exception("Failed to read file content");
        }

        return $content;
    }

}