<?php

// @acton: php detect_wrong_words.php > wrong_words.txt

require_once('../support/_require_once.php');

$dir    = '../texts/Тарас Григорович Шевченко/';
$dir = iconv(mb_detect_encoding($dir, mb_detect_order(), true), "cp1251", $dir);

$files = scandir($dir);

$result = [];

foreach ($files as $file) {
    $result[] = cleanCyrillic($file);
}

print_r($result);


