<?php
namespace serverlogmanager\lib\Utils;

class Utils
{
    public static function filter_str($str)
    {
        $str = trim($str);
        $str = htmlentities($str);
        $str = sanitize_text_field($str);
        return $str;
    }
}