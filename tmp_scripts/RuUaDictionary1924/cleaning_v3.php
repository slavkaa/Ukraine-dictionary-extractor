<?php
// php cleaning_v3.php

require_once('../support/_require_once.php');

$file = file_get_contents('cleaning/v.3.txt');

$lines = explode("\n", $file);

$count = count($lines);

$resultText =  $lines[0];

$j = 0;

$currentLetter = $ruAbcCapitals1924dictionary[$j];

for ($i = 1; $i < $count+1; $i++) {
    $firstLetter1 = mb_substr($lines[$i],0,1);
    $firstLetter2 = mb_substr($lines[$i+1],0,1);
    $firstLetter3 = mb_substr($lines[$i+2],0,1);

    if ($firstLetter1 === $currentLetter || 72470 < $i) { // use new line
        $resultText .= "\n" . $lines[$i];

        echo '.';
    } else {
        $nextCapitalLetter = $ruAbcCapitals1924dictionary[$j + 1];

        $isNextLetter = ($nextCapitalLetter === $firstLetter2 && $nextCapitalLetter === $firstLetter3);

        if (false == in_array($firstLetter2, $ruAbcCapitals1924dictionary)) {
            $resultText .= "\n***" . $lines[$i];
//            $resultText .= sprintf("\n*** (%s, %s, %s)1 ", $firstLetter1, $currentLetter, $j) . $lines[$i];
        } elseif ($isNextLetter) {

            $j++;
            $currentLetter = $ruAbcCapitals1924dictionary[$j];

            $resultText .= "\n" . $lines[$i];

            echo $currentLetter;
        } else {
            $resultText .= "\n***" . $lines[$i];
//            $resultText .= sprintf("\n*** (%s, %s, %s)2 ", $firstLetter1, $currentLetter, $j) . $lines[$i];
//            echo "\n";
//            var_dump($currentLetter, $lines[$i-1],$lines[$i],$lines[$i+1],$lines[$i+2],$lines[$i+3]);
//            die;
        }
    }
}

$resultText = str_replace("\n***", ' ', $resultText);

file_put_contents('cleaning/v.4.txt', $resultText);

// ***
//
//$file = file_get_contents('cleaning/v.4.txt');
//$lines = explode("\n", $file);
//$count = count($lines);
//
//$j = 0;
//$currentLetter = $ruAbcCapitals1924dictionary[$j];
//
//echo "\n\n\n" . $currentLetter;
//
//for ($i = 0; $i < $count+1; $i++) {
//    $firstLetter1 = mb_substr($lines[$i],0,1);
//    if ($firstLetter1 === $currentLetter) {
////        echo '.';
//    } elseif ('*' === $firstLetter1) {
////        echo '*';
//    } else {
//        $nextCapitalLetter = $ruAbcCapitals1924dictionary[$j + 1];
//        if ($nextCapitalLetter === $firstLetter1) {
//            $j++;
//            $currentLetter = $ruAbcCapitals1924dictionary[$j];
//
//            echo $currentLetter;
//        } else {
//            echo "\n";
//            var_dump($i, $currentLetter, $lines[$i-1],$lines[$i],$lines[$i+1],$lines[$i+2],$lines[$i+3]);
//            die;
//        }
//    }
//}