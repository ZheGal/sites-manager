<?php
$randomName = 'backup_' . substr(md5(rand()), 0, 10);
$dirToCopy = implode(DIRECTORY_SEPARATOR, [__DIR__]);
$backupDir = implode(DIRECTORY_SEPARATOR, [__DIR__, '..', 'backup']);
if (!file_exists($backupDir)) {
    mkdir($backupDir);
}

$selfFileName = trim($_SERVER['REQUEST_URI'], '\/');

$exec = exec("cd ../public && zip -r ../backup/{$randomName}.zip ./*");

if (file_exists("../backup/{$randomName}.zip")) {
    $link = "http://{$_SERVER['HTTP_HOST']}/backup/{$randomName}.zip";
    echo $link;
}
