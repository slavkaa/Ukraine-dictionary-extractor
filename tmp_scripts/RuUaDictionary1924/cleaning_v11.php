<?php
// php cleaning_v11.php

require_once('../support/_require_once.php');

// ---

/*
$file = file_get_contents('cleaning/v.11.txt');

$lines = explode("\n", $file);

$resultText = '';

foreach ($lines as $line) {

    $pos = mb_strpos($line, '--');

    $line = mb_substr($line, $pos + 2);

    $resultText .= $line. "\n";
}

file_put_contents('cleaning/v.12.txt', $resultText);
*/

/*
$file = file_get_contents('cleaning/v.6-s++.txt');

$lines = explode("\n", $file);

$resultText = '';

foreach ($lines as $line) {

    $pos = mb_strpos($line, '--');

    $line = mb_substr($line, $pos + 2);

    $resultText .= $line. "\n";

    echo '.';
}

file_put_contents('cleaning/v.12-6.txt', $resultText);
*/

$file = file_get_contents('cleaning/v.10-s++.txt');

$lines = explode("\n", $file);

$resultText = '';

foreach ($lines as $line) {

    $pos = mb_strpos($line, '--');

    $line = mb_substr($line, $pos + 2);

    $resultText .= $line. "\n";

    echo '.';
}

file_put_contents('cleaning/v.12-10.txt', $resultText);