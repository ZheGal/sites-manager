<?php

namespace App\Helpers;

class Settings
{
    public static function getArray($domain)
    {
        $url = 'https://' . $domain . '/settings.json';
        $json = @file_get_contents($url);
        if (!empty($json)) {
            $array = json_decode($json, 1);
            return collect($array);
        }
        return false;
    }
}