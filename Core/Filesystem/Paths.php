<?php

namespace Core\Filesystem;

class Paths
{
    public static function getBasePath()
    {
        return base_path();
    }

    public static function getAppPath()
    {
        return self::getBasePath().'App/';
    }

    public static function getPublicPath()
    {
        return self::getBasePath().'Public/';
    }

    public static function getStoragePath()
    {
        return self::getBasePath().'Storage/';
    }

    public static function getViewPath()
    {
        return self::getAppPath().'Views/';
    }

}