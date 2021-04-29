<?php

namespace App\Helpers;

use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Ftp as Adapter;

class Flysystem
{
    public function __construct($site)
    {
        if (!$this->checkFtpAvailable($site)) {
            return false;
        }

        $host = $site->ftp_host;
        $user = $site->ftp_user;
        $pass = $site->ftp_pass;

        $this->ftp = new Filesystem(new Adapter([
            'host' => $host,
            'username' => $user,
            'password' => $pass,
        ]));

        $this->dir = '';
        $this->checkPublicHtml();
        
        if ($this->dir != '') {
            $this->ftp = new Filesystem(new Adapter([
                'host' => $host,
                'username' => $user,
                'password' => $pass,
                'root' => $this->dir
            ]));
        }
    }

    public function saveSettingsJson($json)
    {
        if (!isset($this->ftp)) {
            return false;
        }

        $file = 'settings.json';
        if ($this->ftp->has($file)) {
            $response = $this->ftp->update($file, $json);
        } else {
            $response = $this->ftp->write($file, $json);
        }
        return $response;
    }

    // получение настроек сайта
    public function getSettingsJson()
    {
        // сначала получаем дефолтные настройки
        // затем проверяем существование файла на сервере
        // если существует, получаем и объединяем
        $default = Settings::getDefaultSettings();
        $settings = [];

        if (!isset($this->ftp)) {
            return $default;
        }
        // проверка существования файла
        $file = 'settings.json';
        if ($this->ftp->has($file)) {
            $settings_json = $this->ftp->read($file);
            if (!empty($settings_json)) {
                $settings_array = json_decode($settings_json, 1);
                if (is_array($settings_array) && !empty($settings_array)) {
                    $settings = $settings_array;
                }
            }
        }

        $settings = array_merge($default, $settings);
        return $settings;
    }

    public function checkPublicHtml()
    {
        if (!isset($this->ftp)) {
            return false;
        }
        
        if ($this->ftp->has('public_html')) {
            $this->dir .= 'public_html/';
        }
    }

    public function uploadNewProject()
    {
        if (!isset($this->ftp)) {
            return false;
        }
        
        $file_path = implode(DIRECTORY_SEPARATOR, [public_path(), 'uploads', 'new_project.php']);
        $contents = file_get_contents($file_path);

        if ($this->ftp->has('.htaccess')) {
            $deleteHtaccess = $this->ftp->delete('.htaccess');
        }
        if ($this->ftp->has('app')) {
            $deleteDir = $this->ftp->deleteDir('app');
        }
        if ($this->ftp->has('index.php')) {
            $deleteIndex = $this->ftp->delete('index.php');
        }

        $response = $this->ftp->write('index.php', $contents);
    }

    public function checkYandex($site)
    {
        $yandex = $site->yandex;
        if (empty($yandex)) {
            return false;
        }
        $settings = $this->getSettingsJson();
        $settings['yandex'] = $yandex;
        $json = json_encode($settings, JSON_PRETTY_PRINT);
        return $this->saveSettingsJson($json);
    }

    public function checkFacebook($site)
    {
        $facebook = $site->facebook;
        if (empty($facebook)) {
            return false;
        }
        $settings = $this->getSettingsJson();
        $settings['facebook'] = $facebook;
        $json = json_encode($settings, JSON_PRETTY_PRINT);
        return $this->saveSettingsJson($json);
    }

    private function checkFtpAvailable($site)
    {
        $host = $site->ftp_host;

        $conn = @ftp_connect($host,'21','5');
        if (empty($conn)) {
            return false;
        }
        return true;
    }
}