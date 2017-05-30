<?php
// php cleaning_v10.php

require_once('../support/_require_once.php');

$file = file_get_contents('cleaning/v.10-h.txt');

$lines = explode("\n", $file);

$resultText = '';
$resultTextE = '';

foreach ($lines as $line) {

    $pos = mb_substr_count($line, '--');

    if (0 === $pos) {
        $resultTextE .= $line. "\n";  // empty
        echo 'e';
    } else {
        $resultText .= $line. "\n";
        echo '.';
    }
}

file_put_contents('cleaning/v.11.txt', $resultText);
file_put_contents('cleaning/v.11-E.txt', $resultTextE);