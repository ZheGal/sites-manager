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

    public static function getGroupArray($str)
    {
        $sites = [];
        $str = trim(
            str_replace("\r\n", "\n", $str)
        );
        $lines = explode("\n", $str);
        foreach ($lines as $line) {
            $site = explode("\t", $line);
            $site = array_values(
                array_diff($site, [''])
            );
            $sites[] = $site;
        }

        if (empty($sites)) {
            return false;
        }

        return $sites;
    }

    public static function getGroupCollect($array, $data)
    {
        $sites = [];

        if (empty($array)) {
            return false;
        }

        foreach ($array as $site) {
            $data = array_merge($data, [
                'domain' => $site[0],
                'ftp_host' => $site[1],
                'ftp_user' => $site[2],
                'ftp_pass' => $site[3],
                'yandex' => (isset($site[4])) ? $site[4] : null,
                'facebook' => (isset($site[5])) ? $site[5] : null,
                'status' => 1
            ]);
            $sites[] = $data;
        }

        return $sites;
    }
}