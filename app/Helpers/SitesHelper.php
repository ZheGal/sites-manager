<?php

namespace App\Helpers;

class SitesHelper
{
    public static function getGetQueries($request)
    {
        $array = [];
        foreach ($request->query() as $param => $value) {
            $array[$param] = $value;
        }

        $array = (!empty($array)) ? array_diff($array, ['']) : [];
        
        return $array;
    }

    public static function getSitesWithFilters()
    {

    }

    public static function getCleanDomain($str)
    {
        $remove = ['http://', 'https://', ' ', '/', '\\', ';', ':', ','];
        $str = str_replace($remove, '', $str);
        return trim($str, ' \/;,.');
    }
}