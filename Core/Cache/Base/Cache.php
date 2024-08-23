<?php

namespace Core\Cache\Base;

class Cache implements ICacheInterface
{
    public $cached;

    public function __construct()
    {
        $this->cached = [];
    }

    public function loadCachedData()
    {
        $config = require_once storage_path('Cache/configs.php');
        $this->cached = $config;
    }

    public function set($key, $value, $time = 0)
    {
        // TODO: Implement set() method.
    }

    public function get($key)
    {
        // TODO: Implement get() method.
    }

    public function delete($key)
    {
        // TODO: Implement delete() method.
    }

    public function clear()
    {
        // TODO: Implement clear() method.
    }

    public function has($key)
    {
        // TODO: Implement has() method.
    }

    public function getMultiple($keys)
    {
        // TODO: Implement getMultiple() method.
    }

    public function setMultiple($values, $time = 0)
    {
        // TODO: Implement setMultiple() method.
    }

    public function deleteMultiple($keys)
    {
        // TODO: Implement deleteMultiple() method.
    }
}