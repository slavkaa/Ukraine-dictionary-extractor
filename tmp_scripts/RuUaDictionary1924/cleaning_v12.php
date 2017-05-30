<?php
// php cleaning_v12.php

require_once('../support/_require_once.php');

//$file = file_get_contents('cleaning/UA_only.v.2.txt');
//$encoding = mb_detect_encoding($file, 'Windows-1251', true);
//$file2 = iconv($encoding, "UTF-8", $file); // back to cyryllic
//file_put_contents('cleaning/UA_only.v.2-UTF8.txt', $file2);
//die;

// --------------------------

//file_put_contents('cleaning/UA_only.v.2-UTF8.txt', $file2);
//$lines = explode("\n", $file2);
//$i = 1;
//$j = 0;
//foreach ($lines as $textOrigin) {
//    echo '.';
//    $i++;
//
//    $data .= $textOrigin . "\n";
//
//    if (3000 === $i) {
//        $i = 0;
//        $j++;
//        file_put_contents('cleaning/Part-'.$j.'.txt', $data);
//        $data = '';
//
//        echo "\n";
//    }
//}
//
//die;

// --------------------------

//for ($i = 0; $i < 31; $i++) {
//    echo $i.'.';
//    $data .= file_get_contents('cleaning/Part-'.$i.'.txt') . "\n";
//}
//
//file_put_contents('cleaning/Parts++.txt', $data);
//
//die;

// --------------------------

$file2 = file_get_contents('cleaning/Parts++.txt');
$lines = explode("\n", $file2);
$resultText = [];

// --------------------------

//$file2 = file_get_contents('cleaning/Part-30.txt');
//$lines = explode("\n", $file2);
//$resultText = [];

foreach ($lines as $textOrigin) {
    echo '<';

    $text = $textOrigin;
    $encoding = mb_detect_encoding($textOrigin, mb_detect_order(), true);
    $text = iconv($encoding, "UTF-8", $textOrigin); // back to cyryllic

    $text = str_replace($pronunciationSings, ' ', $text); // remove pronunciation sings
    $text = str_replace($pronunciationSings, ' ', $text); // remove pronunciation sings
    $text = str_replace($pronunciationSings, ' ', $text); // remove pronunciation sings
    // двічи, щоб гарантовано очистити комбіновані пунктуаційні символи на шкалт [-"(доречі...]
    $text = str_replace($numbers, ' ', $text); // remove pronunciation sings
    $text = str_replace($foreignLetters, ' ', $text); // remove pronunciation sings
    $text = str_replace($foreignLetters, ' ', $text); // remove pronunciation sings
    $text = str_replace(['  ','  ','  ','  ','  ','  ','  ',' -','- '
        ,' `','` '," '","' ",' "','" ',' ‘','‘ '], ' ', $text); // remove pronunciation sings

    $textWords = array_unique(explode(' ', $text));

    $j = 1;
    foreach ($textWords as $textWord) {
        $textWord = trim($textWord);
        $textWord = str_replace(["'", '"','’','‘','?','?','’'], ['`','`','`','`','о','у','`'], $textWord);

        // @link: stackoverflow.com/questions/1176904/php-how-to-remove-all-non-printable-characters-in-a-string
//        $textWord = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F-\x9F]/u', '', $textWord);

        if ("" == $textWord || empty($textWord)) {
            echo 'e';
            continue;
        }

        // check for all non UKR symbols
        $checkWord = str_replace($ukraineAbc, '', $textWord);
        $checkWord = str_replace('*', '', $checkWord);
        $checkWord = str_replace('(', '', $checkWord);
        $checkWord = str_replace(')', '', $checkWord);
        if ("" !== $checkWord || !empty($checkWord)) {
            echo "\n";
            var_dump($i);
            var_dump($j);
            var_dump($textOrigin);
            var_dump($textWord);
            var_dump($checkWord);
            die(' err1');
        }

        $checkWord = str_replace(['`','-',' '], '', $textWord);
        if ("" == $checkWord || empty($checkWord)) {
            echo 'e';
            continue;
        }

        $resultText[$textWord] = $textWord;
        echo '+';
        $j++;
    }

    echo '>';
    $i++;
}

file_put_contents('cleaning/UA_only.v.3.txt', implode("\n", $resultText));


// (*) - '
// (**) - ’ - `
// (***) - ґ
// (****) - Ґ
// -- (*****) - д
// (******) - Б
// (*******) - В
//
