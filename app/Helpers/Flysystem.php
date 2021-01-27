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
        
            /** optional config settings */
            'port' => 21,
            'root' => '/',
            'passive' => true,
            'ssl' => true,
            'timeout' => 30,
            'ignorePassiveAddress' => false,
        ]));

        $this->dir = '/';
        $this->checkPublicHtml();
    }

    public function saveSettingsJson($json)
    {
        $file = $this->dir . '/settings.json';
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


    
}