<?php
// php cleaning_v14.php

require_once('../support/_require_once.php');

$file = file_get_contents('cleaning/Clean_v.1++.txt');

$lines = explode("\n", $file);

$resultText = '';
$resultTextW = '';

foreach ($lines as $line) {
//    echo '.';
    if (1 < mb_substr_count($line, "'")) {
        $resultTextW .= $line . "\n";
    } else {
        $resultText .= $line . "\n";
    }
}

file_put_contents('cleaning/Clean_v.2.txt', $resultText);
file_put_contents('cleaning/Clean_v.2-W.txt', $resultTextW);