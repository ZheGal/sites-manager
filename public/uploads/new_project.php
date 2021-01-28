<?php
unlink("index.php");
$appDir = dirs(__DIR__, 'app');
$pubDir = dirs(__DIR__, 'public');
$dirr = __DIR__;

if(file_exists($appDir) && is_dir($appDir)) {
    $command = "cd {$dirr} && rm -rf app/ 2>&1";
    echo exec($command);
}

if (!file_exists($appDir)) {
    // создаём папку app
    mkdir ($appDir);
}

if (!file_exists($pubDir)) {
    // создаём папку public
    mkdir ($pubDir);
}

downloadApp();
unpackApp();
removeDir();

require_once("app/index.php");

///// 

function dirs(...$array) {
    return implode(DIRECTORY_SEPARATOR, $array);
}

function downloadApp()
{
    $root = dirs(__DIR__, 'app');

    $commands = implode(" && ", [
        "cd {$root}",
        "wget -O app.zip 'https://github.com/ZheGal/offers-sites-connector/archive/main.zip'"
    ]);

    return exec($commands);
}

function unpackApp()
{
    $root = dirs(__DIR__, 'app');
    $commands = implode(" && ", [
        "cd {$root}",
        "unzip -o app.zip",
        "rm -rf app.zip",
        "mv offers-sites-connector-main/* ."
    ]);

    return exec($commands);
}

function removeDir()
{
    $root = dirs(__DIR__, 'app');
    $commands = implode(" && ", [
        "cd {$root}",
        "rm -rf offers-sites-connector-main/"
    ]);

    return exec($commands);
}