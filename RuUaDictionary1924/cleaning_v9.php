<?php
// php cleaning_v9.php

require_once('../support/_require_once.php');

$file = file_get_contents('cleaning/v.9.txt');

$lines = explode("\n", $file);

$count = count($lines);

$resultTextS = '';
$resultTextM1 = '';
$resultTextM2 = '';
$resultTextH = '';

$sample = 25;

$counter = 0;

for ($i = 0; $i < $count+1; $i++) {

    $interpretationCounter = mb_substr_count($lines[$i], " – ");
    $dotsCounter = mb_substr_count($lines[$i], '.');

    $isSingleInterpretation = (1 == $interpretationCounter);
    $isDoubleInterpretation = (2 == $interpretationCounter);
    $isSimpleForm = true;

    $parts = explode(" – ", $lines[$i]);
    $part2 = array_get($parts, 1);

    $isSimpleDost =  $dotsCounter < 2;
    $isDoubleDost =  2 == $dotsCounter;

    if ($isSingleInterpretation && $isSimpleForm && $isSimpleDost) {
       $resultTextS .= $lines[$i] . "\n";
       echo 'S';
    } elseif ($isDoubleInterpretation && $isSimpleForm && $isDoubleDost) {
        $parts = explode('.', $lines[$i]);

        $resultTextS .= $parts[0] . "\n";
        $resultTextS .= $parts[1] . "\n";
        echo '+';
    }  else {
        $resultTextH .= $lines[$i] . "\n";
        echo '-';
    }
}

file_put_contents('cleaning/v.10-s.txt', $resultTextS);
file_put_contents('cleaning/v.10-h.txt', $resultTextH);

