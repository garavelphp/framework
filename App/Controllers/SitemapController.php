<?php

namespace App\Controllers;

use Core\Controllers\BaseController;

class SitemapController extends BaseController
{



    public function getSitemap()
    {
        $sitemap = new \Core\SiteMap\SiteMap();
        echo $sitemap->generateXML();
    }

}