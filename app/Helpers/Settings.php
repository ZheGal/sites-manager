<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\Site;

class Settings
{
    public static function settingsFileExists($domain)
    {
        $url = 'http://' . $domain . '/settings.json';
        $json = @file_get_contents($url);
        if (empty($json)) {
            return false;
        }
        
        $array = json_decode($json, 1);
        if (is_array($array) && !empty($array)) {
            return true;
        }
        return false;
    }

    public static function getArray($domain)
    {
        $site = Site::where('domain', $domain)->first();
        if (!$site) {
            return [];
        }
        $fly = new Flysystem($site);
        $settings = $fly->getSettingsJson();
        return $settings;
    }

    public static function compareSettingAfterUpdateSubmit()
    {
        $template = self::getDefaultSettings();
        $updated = [];
        
        if (isset($_POST) && !empty($_POST)) {
            foreach ($_POST as $param => $val) {
                if ($param[0] != '_') {
                    $updated[$param] = $val;
                }
            }
        }
        $array = array_merge($template, $updated);
        $array = array_filter($array, function($element) {
            return !empty($element);
        });
        return $array;
    }

    public static function compareSettingsAfterCreate($site)
    {
        return self::getDefaultSettings();
    }

    public static function getDefaultSettings()
    {
        $array = [
            'group' => '21',
            'pid' => 'lz9mjv',
            'return' => 'thanks.php',
            'yandex' => '',
            'facebook' => '',
            'partner' => [
                'neogara' => 1,
                'neogara_js' => 0
            ],
            'country' => '', // для указания дефолтной страны
            'intlToken' => '',  // для указания токена для определения страны
            'language' => '',
            'sitename' => '',
            'cloakit' => '',
            'relink' => '', // для прокл
            'send_mail' => '', // дописываем, если нужно поменять адрес отправки почты после отправки формы на глобалмаксис
            'autologin' => 3,
            'sub1' => '',
            'sub2' => '',
            'sub3' => '',
            'sub4' => '',
            'sub5' => '',
            'sub6' => '',
            'sub7' => '',
            'sub8' => ''
        ];

        return $array;
    }

    public static function updateSite($site)
    {
        $fly = new Flysystem($site);
        $settings = $fly->getSettingsJson();

        $pid = self::getUserPid($site);

        $settings = array_merge($settings, [
            'pid' => $pid,
            'group' => $site->campaign_id,
            'yandex' => $site->yandex,
            'facebook' => $site->facebook,
            'cloakit' => $site->cloakit,
            'relink' => $site->relink
        ]);

        $settings = self::removeNullSettings($settings);
        
        $json = json_encode($settings, JSON_PRETTY_PRINT);
        $save = $fly->saveSettingsJson($json);

        return ($save) ? 'Файл settings.json на сервере обновлён.' : 'Файл settings.json на сервере не был обновлён.';
    }

    public static function getUserPid($site)
    {
        $id = $site->user_id;
        $user = User::find($id);
        if ($user) {
            return $user->pid;
        }
        return 'lz9mjv';
    }

    public static function getCompareWithBase($settings, $site)
    {
        $settings['campaign_id'] = $settings['group'];
        unset($settings['group']);

        $site_array = array_filter($site->toArray(), function($element) {
            return !empty($element);
        });

        $all = array_merge($settings, $site_array);
        $all['type'] = (empty($all['type'])) ? 'land' : $all['type'];
        if (!isset($all['hoster_id'])) {
            $all['hoster_id'] = 0;
        }
        if (!isset($all['hoster_id_domain'])) {
            $all['hoster_id_domain'] = 0;
        }
        if (!isset($all['user_id'])) {
            $all['user_id'] = 0;
        }
        $all = (object) $all;

        // print_r($all);
        // die;
        
        return $all;
    }

    public static function createNewSite($data)
    {
        print_r($data);
        die;
    }

    public static function checkPid($data)
    {
        // возвращать false, если не пришёл пид и нет пользователя
        if (empty($data['user_id']) && empty($data['pid'])) {
            return false;
        }

        if (isset($data['pid'])) {
            $data['pid'] = trim(str_replace(" ", "", $data['pid']));
        }
        // если пид пришёл, проверяем на пустоту
        if (isset($data['pid']) && !empty($data['pid']) && $data['pid'] != '') {
            return $data['pid'];
        }
        
        // выполнять в последнюю очередь, если пустое значение пид
        $user = User::find($data['user_id']);
        if (isset($user->pid) && !empty($user->pid)) {
            return $user->pid;
        }
    }
    
    public static function newSiteSettings($request)
    {
        $new = [];
        foreach ($request->toArray() as $param => $val) {
            if ($param[0] != '_') {
                $new[$param] = $val;
            }
        }

        $new = self::removeParams($new, ['ftp_host', 'ftp_user', 'ftp_pass', 'hoster_id', 'hoster_id_domain', 'user_id', 'clean_host']);
        
        $fly = new Flysystem($request);
        
        $settings = $fly->getSettingsJson();
        $new['pid'] = self::checkPid($request->toArray());

        $new = array_merge($settings, $new);
        $new = self::removeNullSettings($new);
        $json = json_encode($new, JSON_PRETTY_PRINT);

        $fly->saveSettingsJson($json);
        return $new;
    }

    public static function removeParams($settings, $params)
    {
        foreach ($params as $param) {
            if (isset($settings[$param])) {
                unset($settings[$param]);
            }
        }
        return $settings;
    }

    public static function removeNullSettings($array)
    {
        $new_array = array_filter($array, function($element) {
            return !empty($element);
        });
        return $new_array;
    }
}