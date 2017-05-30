<?php

// @acton1: php replace_wrong_capital_words.php

require_once('../support/_require_once.php');

require_once('config_uncapitalize/sheva.php');

$wrongWords = [];

echo "\n";

$capitalLettersWords = [];

foreach ($titles as $title) {
    echo $title . ':';

    $filename = sprintf('../texts/%s/processed/%s', $author, $title);

    $filename = iconv(mb_detect_encoding($filename, mb_detect_order(), true), "cp1251", $filename);
    $text = file_get_contents($filename);

    $text = str_replace($pronunciationSings, ' ', $text);
    $text = str_replace($pronunciationSings, ' ', $text);

    $text = str_replace('  ', ' ', $text);
    $text = str_replace('  ', ' ', $text);
    $text = str_replace('  ', ' ', $text);
    $text = str_replace('  ', ' ', $text);
    $text = str_replace('  ', ' ', $text);
    $text = str_replace('  ', ' ', $text);
    $text = str_replace("'", '`', $text);

    $textWords = array_unique(explode(' ', $text));

    foreach ($textWords as $textWord) {
        $textWord = trim($textWord);

        if (array_in_string($capitalLetters, $textWord)) {
            $capitalLettersWords[] = $textWord;
        }
    }

    $filenameOddWords = sprintf('../texts/%s/uncapitalized/%s', $author, $title);
    $filenameOddWords = iconv(mb_detect_encoding($filenameOddWords, mb_detect_order(), true), "cp1251", $filenameOddWords);

    file_put_contents(
        $filenameOddWords,
        implode("\n", $capitalLettersWords)
    );
}






