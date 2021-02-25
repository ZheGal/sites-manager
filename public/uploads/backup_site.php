<?php

$randomName = 'backup_' . substr(md5(rand()), 0, 10);

$dirToCopy = implode(DIRECTORY_SEPARATOR, [__DIR__, '..', 'pubilc']);
$exec = exec("cd ../public && zip -r ../backup/{$randomName}.zip ./*");

if (file_exists("{$randomName}.zip")) {
    $link = "http://{$_SERVER['HTTP_HOST']}/backup/{$randomName}.zip";
    echo $link;
}