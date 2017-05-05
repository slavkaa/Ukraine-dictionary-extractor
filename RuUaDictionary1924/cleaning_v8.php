<?php
// php cleaning_v7.php

require_once('../support/_require_once.php');

$file = file_get_contents('cleaning/v.8.txt');

$lines = explode("\n", $file);
$resultText = '';

foreach ($lines as $line) {
    preg_match_all('#\((.*?)\)#', $line, $matches);

    $phrases = $matches[0];

//    if (!empty($phrases)) {
//        var_dump($phrases);
//    }

    foreach ($phrases as $phrase) {
        $line = str_replace($phrase, '', $line);
    }

    $resultText .= $line. "\n";
    echo '.';
}

file_put_contents('cleaning/v.9.txt', $resultText);