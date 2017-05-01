<?php

// @acton: php scandir.php > arr_if.txt

require_once('../support/_require_once.php');

$dir    = '../texts/Довженко Олександр/';
$dir = iconv(mb_detect_encoding($dir, mb_detect_order(), true), "cp1251", $dir);

$files = scandir($dir);

$result = [];

echo "[\n";

$i = 0;
foreach ($files as $file) {
//    $result[] = cleanCyrillic($file);
    $title = cleanCyrillic($file);
    $title = str_replace('\'', '\\\'', $title);

    if (in_array($title, ['.', '..'])) {
        continue;
    }

    echo "    $i => '$title',\n";
    $i++;
}

echo ']';

//print_r($result);


