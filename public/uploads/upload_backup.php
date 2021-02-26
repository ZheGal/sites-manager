<?php
header("Content-type:text/plain");

$fileName = trim($_SERVER['REQUEST_URI'], '\/');
$fileNameA = explode("?", $fileName);
$fileName = $fileNameA[0];

$root = __DIR__;

$self = implode(DIRECTORY_SEPARATOR, [$root, $fileName]);
unlink($self);

$commands = implode(" && ", [
    "cd {$root}",
    "wget -O public.zip '%%ARCHIVE_URL%%'",
    "unzip -o public.zip",
    "rm -rf public.zip",
]);

return exec($commands);