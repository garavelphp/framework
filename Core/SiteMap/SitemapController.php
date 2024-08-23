<?php

namespace Core\SiteMap;

use Core\Controllers\BaseController;

class SitemapController extends BaseController
{

    /**
     * @throws \Exception
     */
    public function getSitemap()
    {
        $sitemap = new SiteMap();
        return $sitemap->generate(config('app.sitemap'));
    }
}