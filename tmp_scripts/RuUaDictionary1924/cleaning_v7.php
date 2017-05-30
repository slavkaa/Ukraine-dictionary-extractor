<?php
// php cleaning_v7.php

require_once('../support/_require_once.php');

$file = file_get_contents('cleaning/v.7_p.txt');

$lines = explode("\n", $file);

$resultText8 = '';
$resultText8b = '';

foreach ($lines as $line) {
    preg_match_all("/\[[^\]]*\]/", $line, $matches);

    $phrases = $matches[0];

    foreach ($phrases as $phrase) {

        $line = str_replace($phrase, '', $line);
        $phrase = str_replace('[', '', $phrase);
        $phrase = str_replace(']', '', $phrase);

        $resultText8b .= $phrase. "\n";

        echo '.';
    }

    $resultText8 .= $line. "\n";
    echo '_';
}

file_put_contents('cleaning/v.8.txt', $resultText8);
file_put_contents('cleaning/v.8_b.txt', $resultText8b);