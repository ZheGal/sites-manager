<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Eseath\SxGeo\SxGeo;

class ApiLocation extends Controller
{
    public function get_location($ip)
    {
        $sxGeo = new SxGeo('../ignored/SxGeoCity.dat');
        $info  = $sxGeo->getCityFull($ip);

        $result = [];
        $result['ip'] = $ip;
        if (isset($info['country'])) {
            $result['full_name'] = $info['country']['name_en'];
            $result['country'] = $info['country']['iso'];
        }
        if (isset($info['city']['name_en'])) {
            $result['city'] = $info['city']['name_en'];
        }
        
        return response()->json($result);
    }
}
