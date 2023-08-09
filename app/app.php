<?php

declare(strict_types=1);
include 'database.php';

function getFileLocations(string $fileName): array
{
    $files = [];
    foreach (scandir("../templates") as $file) {
        if (
            is_dir("../templates/$file")
        ) {
            foreach (scandir("../templates/$file") as $f) {
                if (
                    is_dir("../templates/$file/$f")
                ) {
                    continue;
                } else {
                    if (
                        basename("../templates/$file/$f") == $fileName
                    ) {
                        $files[] = "../templates/$file/$f";
                    } else {
                        continue;
                    }
                }
            }
        }
    }
    return $files;
}

function getFormLocations(string $fileName): array
{
    $files = [];
    foreach (scandir("../templateForm") as $file) {
        if (
            is_dir("../templateForm/$file")
        ) {
            foreach (scandir("../templateForm/$file") as $f) {
                if (
                    is_dir("../templateForm/$file/$f")
                ) {
                    continue;
                } else {
                    if (
                        basename("../templateForm/$file/$f") == $fileName
                    ) {
                        $files[] = "../templateForm/$file/$f";
                    } else {
                        continue;
                    }
                }
            }
        }
    }
    return $files;
}

$str = "../templates"; 

function getSiteName(): array
{
    $names = [];
    foreach (scandir("../templates") as $file) {
        if (
            is_dir("../templates/$file")
        ) {
            foreach (scandir("../templates/$file") as $f) {
                if (
                    is_dir("../templates/$file/$f")
                ) {
                    continue;
                } else {
                    if (
                        basename("../templates/$file/$f") == 'name.txt'
                    ) {
                        $fileName = fopen("../templates/$file/$f", 'r');
                        $name = fgets($fileName);
                        $names[] = $name;
                    } else {
                        continue;
                    }
                }
            }
        }
    }
    return $names;
}


function zippingFolder(string $pathDir, string $zipcreated)
{
    $zip = new ZipArchive;

    if ($zip->open($zipcreated, ZipArchive::CREATE) === TRUE) {

        $dir = opendir($pathDir);

        while ($file = readdir($dir)) {
            if (is_file($pathDir . $file)) {
                $zip->addFile($pathDir . $file, $file);
            }
        }
        $zip->close();
    }
}

