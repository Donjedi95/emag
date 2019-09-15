<?php

namespace App\utils;

class Utils
{
    /**
     * @param float $min
     * @param float $max
     * @param int $decimals
     * @return float
     */
    public static function randomFloat(float $min = 0, float $max = 1, $decimals = PHP_FLOAT_DIG)
    {
        return number_format($min + mt_rand() / mt_getrandmax() * ($max - $min), $decimals);
    }

    /**
     * @param $classname
     * @return bool|int|string
     */
    public static function get_class_name($classname)
    {
        if ($pos = strrpos($classname, '\\')) return substr($classname, $pos + 1);
        return $pos;
    }
}
