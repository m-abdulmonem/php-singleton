<?php

namespace Mabdulmonem\System;

class ModelHelper
{

    public static function __callStatic(string $name, array $arguments)
    {
        if (property_exists(self::class, $name)){
            dd($name, $arguments);
            return (new self(self::$a))->$name(...$arguments);
        }
    }
}