<?php
// php cleaning_v2.php

require_once('../support/_require_once.php');

$file = file_get_contents('cleaning/v.2.txt');

$lines = explode("\n", $file);

$resultText = '';

foreach ($lines as $line) {
    if (empty($line)) {

    } else {
        $resultText .= $line . "\n";
    }
}

file_put_contents('cleaning/v.3.txt', $resultText);