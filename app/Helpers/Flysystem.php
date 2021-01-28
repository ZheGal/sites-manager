<?php

namespace App\Helpers;

use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Ftp as Adapter;

class Flysystem
{
    public function __construct($site)
    {
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
    }

    public function saveSettingsJson($json)
    {
        $file = $this->dir . 'settings.json';
        if ($this->ftp->has($file)) {
            $response = $this->ftp->update($this->dir . '/settings.json', $json);
        } else {
            $response = $this->ftp->write($this->dir . '/settings.json', $json);
        }
        return $response;
    }

    public function checkPublicHtml()
    {
        if ($this->ftp->has('/public_html/')) {
            $this->dir .= 'public_html/';
        }
    }

    public function uploadNewProject()
    {
        $file_path = implode(DIRECTORY_SEPARATOR, [public_path(), 'uploads', 'new_project.php']);
        $contents = file_get_contents($file_path);

        if ($this->ftp->has($this->dir . '.htaccess')) {
            $deleteHtaccess = $this->ftp->delete($this->dir . '.htaccess');
        }
        if ($this->ftp->has($this->dir . 'app')) {
            $deleteDir = $this->ftp->deleteDir($this->dir . 'app');
        }
        if ($this->ftp->has($this->dir . 'index.php')) {
            $deleteIndex = $this->ftp->delete($this->dir . 'index.php');
        }

        $response = $this->ftp->write($this->dir . 'index.php', $contents);
    }
}