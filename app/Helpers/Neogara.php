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
        if ($this->isError($http)) {
            $this->updateToken();
            $this->get_offers();
        }
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

    public function isError($http)
    {
        $obj = $http->object();
        if (isset($obj->statusCode)) {
            return ($obj->statusCode == '401' && $obj->message == 'Unauthorized');
        }
        return false;
    }

    private function updateToken()
    {
        $settings = [
            'username' => Setting::where('param', 'neogara_login')->first()['value'],
            'password' => Setting::where('param', 'neogara_password')->first()['value'],
        ];
        $token = $this->get_auth($settings);
        $this->token = $token;

        $setting = Setting::where('param', 'neogara_token')->first();
        $setting->value = $token;
        $setting->save();
    }
}