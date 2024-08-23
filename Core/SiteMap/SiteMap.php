<?php

namespace Core\SiteMap;

use Core\Router\Router;
use SimpleXMLElement;

class SiteMap
{

    private array $items = [];
    public function __construct()
    {
        $this->loadRoutes();
    }


    /**
     * @throws \Exception
     */
    public function generate($type = null): bool|string
    {


        die(config('app.sitemap_ext'));
        if ($type == null) {
            $type = config('app.sitemap_ext');
        }

        die($type);

        if ($type == 'xml') {
            return $this->generateXML();
        } else if ($type == 'html') {
            return $this->generateHTML();
        }else{
            throw new \Exception('Invalid type');
        }

    }

    public function generateXML(): string|bool
    {
        header('Content-Type: application/xml; charset=utf-8');
        $xml = new SimpleXMLElement('<urlset/>');
        $xml->addAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        foreach ($this->items as $item){
            $url = $xml->addChild('url');
            $url->addChild('loc', $item['url']);
            $url->addChild('lastmod', $item['lastmod']);
            $url->addChild('changefreq', $item['changefreq']);
            $url->addChild('priority', $item['priority']);
        }
        return $xml->asXML();
    }

    public function generateHTML(): string
    {
        $html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Map</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            color: #333;
        }
        ul {
            list-style-type: none;
        }
        li {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <h1>Site Map</h1>
        <ul>';
        foreach ($this->items as $item){
            $html .= '<li><a href="'.$item['url'].'">'.$item['url'].'</a></li>';
            $html .= " (Priority: {$item['priority']}, Change Frequency: {$item['changefreq']}, Last Modified: {$item['lastmod']})";
        }
        $html .= '</ul>
</body>
</html>
';
        return $html;
    }



    public function add($url, $priority = 0.5, $changefreq = 'daily', $lastmod = null): void
    {
        $this->items[] = [
            'url' => $url,
            'priority' => $priority,
            'changefreq' => $changefreq,
            'lastmod' => $lastmod ?? date('Y-m-d')
        ];
    }

    public function loadRoutes(): void
    {
    $router = new Router();
    $routes = $router->getRoutes('GET');

        array_map(function ($routes){
            $this->add($routes['full_url']);
        },$routes);
    }

}