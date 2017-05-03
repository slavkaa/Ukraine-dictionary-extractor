<?php
// php cleaning_v5.php

require_once('../support/_require_once.php');

$file = file_get_contents('cleaning/v.5.txt');

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
    $isSimpleForm = (false == mb_strpos($lines[$i], ')')) && (false == mb_strpos($lines[$i], ']'));

    $parts = explode(" – ", $lines[$i]);
    $part2 = array_get($parts, 1);

    $isSimpleDost =  $dotsCounter < 2;
    $isDoubleDost =  2 == $dotsCounter;

//    var_dump($lines[$i]);
//    var_dump(mb_substr_count($lines[$i], " – "));
//    var_dump(mb_strpos($lines[$i], ')'));
//    var_dump($isSingleInterpretation, $isSimpleForm, $isDoubleDost);
//    die;

    if ($isSingleInterpretation && $isSimpleForm && $isSimpleDost) {
       $resultTextS .= $lines[$i] . "\n";
       echo 'S';
    } elseif ($isDoubleInterpretation && $isSimpleForm && $isDoubleDost) {
        $parts = explode('.', $lines[$i]);

        $resultTextS .= $parts[0] . "\n";
        $resultTextS .= $parts[1] . "\n";
        echo '+';
    } /*elseif ($interpretationCounter == $dotsCounter) {
        $parts = explode('.', $lines[$i]);

        for ($j = 0; $j < $dotsCounter; $j++) {
            $resultTextM1 .= $parts[$j] . "\n";
        }

        echo 'M1';
    }*/ else {
        $resultTextH .= $lines[$i] . "\n";
        echo '-';
    }
}

file_put_contents('cleaning/v.6-s.txt', $resultTextS);
//file_put_contents('cleaning/v.6-m1.txt', $resultTextM1);
//file_put_contents('cleaning/v.6-m2.txt', $resultTextM2);
file_put_contents('cleaning/v.6-h.txt', $resultTextH);

function replacer($line)
{
    return str_replace(
        [' сз. ', ' межд. ', ' (р. '],
        [' *сполучник* ', ' *вигук* ', ' (*родовий відмінок* ']
        ,$line
    );
}