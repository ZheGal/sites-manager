<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use App\Models\Setting;

class Neogara
{
    private $main_url;
    private $token;

    public function __construct($data = [])
    {
        $setting = Setting::where('param', 'neogara_token')->first();
        
        $this->main_url = 'https://admin.neogara.com/';
        if ($setting) {
            $this->token = $setting->value;
        }
    }

    public function get_offers()
    {
        $link = $this->main_url . 'pipelines';
        $http = Http::withToken($this->token)->get($link);
        return collect($http->object());
    }

    public function get_offer($id)
    {
        $link = $this->main_url . 'pipelines/' . $id;
        $http = Http::withToken($this->token)->get($link);
        return collect($http->object());
    }

    public function get_auth($data)
    {
        $url = $this->main_url . 'auth/login';
        $auth = Http::asForm()->post($url, $data);
        $array = json_decode($auth, 1);
        if (is_array($array) && isset($array['access_token'])) {
            return $array['access_token'];
        }
        return false;
    }
}