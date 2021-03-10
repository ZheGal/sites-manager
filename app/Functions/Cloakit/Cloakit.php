<?php

namespace App\Functions\Cloakit;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use App\Helpers\Neogara;
use App\Helpers\Offers;
use App\Helpers\Settings;

class Cloakit
{
    private $email;
    private $password;
    private $auth;

    public function __construct()
    {
        $email = Setting::where('param', 'cloakit_login')->first();
        $password = Setting::where('param', 'cloakit_pass')->first();
        if (empty($email) || empty($password)) {
            return false;
        }
        $this->email = $email->value;
        $this->password = $password->value;
        $this->get_auth();
    }

    public function newcampaign($array = [])
    {
        $url = 'https://panel.cloakit.space/ajax/campaigns/newcampaign.php';
        $template = $this->get_cloakit_template();
        $array = array_merge($template, $array);
        $request = Http::asForm()->withHeaders([
            'Cookie' => $this->get_cookie_auth()
        ])->post($url, $array);

        $create = $request->getBody();
        $id = $this->get_new_id($create);

        return [
            'id' => $id,
            'name' => (isset($array['campaign_name'])) ? $array['campaign_name'] : false,
            'domain' => (isset($array['domain'])) ? $array['domain'] : false,
            'black' => (isset($array['black_page'])) ? $array['black_page'] : false,
            'white' => (isset($array['white_page'])) ? $array['white_page'] : false
        ];
    }

    protected function get_auth()
    {
        $authUrl = 'https://panel.cloakit.space/ajax/signin/signin.php';

        $resp = Http::asForm()->post($authUrl, [
            'Email' => $this->email,'Password' => $this->password
        ]);
        $this->auth = strval($resp->getBody());
    }

    protected function get_cloakit_user()
    {
        $auth = $this->auth;
        $array = json_decode($auth, 1);
        return $array['CLK_USER'];
    }

    protected function get_cloakit_template()
    {
        $template = [
            'campaign_name' => '',
            'white_page' => 'w.php',
            'black_page' => 'b.php',
            'black_page_perc' => '100',
            'blackpage_two' => '',
            'blackpage_two_perc' => '',
            'blackpage_three' => '',
            'blackpage_three_perc' => '',
            'blackpage_four' => '',
            'blackpage_four_perc' => '',
            'blackpage_five' => '',
            'blackpage_five_perc' => '',
            'status_settings' => 'on',
            'count_views' => '',
            'page_type' => 'load',
            'bots' => 'on',
            'vpn' => 'on',
            'geo_settings' => 'allow',
            'geohelp' => '',
            'country_name' => '',
            'ip_settings' => 'off',
            'ip_list' => '',
            'isp_settings' => 'off',
            'isp_list' => '',
            'referer_settings' => 'off',
            'referer_list' => '',
            'useragent_settings' => 'off',
            'useragent_list' => '',
            'urlparams_settings' => 'off',
            'urlparams_list_allow' => '',
            'urlparams_list_disallow' => '',
            'user' => $this->get_cloakit_user()
        ];
        return $template;
    }

    private function get_cookie_auth()
    {
        $return = [];
        $auth = $this->auth;
        $array = json_decode($auth, 1);
        foreach ($array as $param => $val) {
            $return[] = $param.'='.$val;
        }
        return implode("; ", $return);
    }

    private function get_new_id($raw = '')
    {
        $re = '/\/(\d+)"/msU';
        preg_match_all($re, $raw, $matches);
        if (isset($matches[1][0])) {
            return $matches[1][0];
        }
        return false;
    }

    public function get_clean_request($array = [])
    {
        $neo = new Neogara();
        $offers = $neo->get_offers();

        $campaigns = [];

        if (isset($array['campaign_id']) && !empty($array['campaign_id'])) {
            $name = Offers::get_offer_name($offers, $array['campaign_id']);
        } else {
            return false;
        }
        
        $domains = $this->get_domains($array);
        if (!empty($domains)) {
            foreach ($domains as $domain) {
                $campaigns[] = [
                    'campaign_name' => $name . ' - ' . rand() . " ({$domain})",
                    'vpn' => (isset($array['proxyvpn']) && $array['proxyvpn'] == '1') ? 'on' : 'off',
                    'country_name' => $array['cloakitCountries'],
                    'domain' => $domain
                ];
            }
        }
        
        return $campaigns;
    }

    public function get_domains($array = [])
    {
        $new = [];
        if (isset($array['domains']) && !empty($array['domains'])) {
            $domains = str_replace(" ", "\n", $array['domains']);
            $domains = str_replace("\r\n", "\n", $array['domains']);
            $domains = explode("\n", $domains);
            $domains = array_values(array_diff(Settings::removeNullSettings($domains), ['', ' ']));
            foreach ($domains as $domain) {
                $new[] = trim($domain);
            }
        }
        return $new;
    }
}