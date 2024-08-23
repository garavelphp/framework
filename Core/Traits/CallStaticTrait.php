<?php

namespace Core\Traits;

trait CallStaticTrait
{

    public static function __callStatic($name, $arguments)
    {
        $instance = new static();

        if (method_exists($instance, $name)) {
            return $instance->$name(...$arguments);
        }

        throw new \Exception("Method $name not found");
    }
}