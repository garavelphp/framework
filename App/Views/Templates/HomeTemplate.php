<?php

namespace App\Views\Templates;

use App\Classes\View;

class HomeTemplate
{

    /**
     * @return string
     * @throws \Exception
     */
    public function handle($data): string
    {

        return (new View())->makeFromString(
            $this->getContent(),
            $data
        )->render();

    }

    /**
     * @throws \Exception
     */
    private function getContent(): string
    {
        $header = $this->getHeader();
        $footer = $this->getFooter();
        $content = $this->getBody();
        return $header . $content . $footer;
    }

    private function getHeader(): string
    {
        return '<header>Header</header>';
    }

    private function getFooter(): string
    {
        return '<footer>Footer</footer>';
    }

    /**
     * @throws \Exception
     */
    private function getBody(): string
    {
        return files()->open(view_path('partitials/home.php'));
    }

}