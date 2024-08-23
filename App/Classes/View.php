<?php

namespace App\Classes;

use Core\Filesystem\File;

class View
{

    private $view;
    private $data;
    /**
     * @throws \Exception
     */
    public function make($path, $data)
    {
        $viewFile = files()->open($path);
        $this->view = $viewFile;
        $this->data = $data;
        return $this;
    }

    public function makeFromString($string,$data)
    {
        $this->view = $string;
        $this->data = $data;
        return $this;
    }


    public function render()
    {
        $data = $this->data;
        $view = $this->view;
        extract($data);
        ob_start();
        eval('?>' . $view.'<?php');
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

}