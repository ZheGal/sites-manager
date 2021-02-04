<?php

namespace App\Helpers;

class Settings
{
    public static function getArray($domain)
    {
        $template = self::getDefaultSettings();
        $url = 'https://' . $domain . '/settings.json';
        $json = @file_get_contents($url);
        if (!empty($json)) {
            $array = json_decode($json, 1);
            $array = array_merge($template, $array);
            return $array;
        }
        return $template;
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
            'domain' => '',
            'cloakit' => '',
            'relink' => '', // для прокл
            'send_mail' => '', // дописываем, если нужно поменять адрес отправки почты после отправки формы на глобалмаксис
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
}