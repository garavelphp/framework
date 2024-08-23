<?php

namespace Core\Cache\Base;

interface ICacheInterface
{

    public function set($key, $value, $time = 0);

    public function get($key);

    public function delete($key);

    public function clear();

    public function has($key);

    public function getMultiple($keys);

    public function setMultiple($values, $time = 0);

    public function deleteMultiple($keys);

}