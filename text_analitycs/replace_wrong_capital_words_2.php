<?php

// @acton: php replace_wrong_capital_words_2.php

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

        echo '.';
        $textWord = trim($textWord);

        if (array_in_string($capitalLetters, $textWord)) {

            $word = new Word($dbh);
            $result = new LcorpResults($dbh);
            $capitalWord = new CapitalWord($dbh);

            $capitalWord->getByWordBinary($textWord);
            if ($capitalWord->getId()) {
                continue; // word already in table
            }

            $word->findByWord($textWord);

            if (null !== $word->getId()) {
                $partOfLanguage = $word->getProperty('part_of_language');

                if (in_array($partOfLanguage, ['іменник', 'чоловіче ім`я', 'жіноче ім`я'])) {
                    $capitalWord->firstOrNewByWordBinary($textWord);
                    $capitalWord->updateProperty('is_capital', PDO::PARAM_BOOL, true);
                    echo '+';
                }
            } else {

                $result->findByWord($textWord);

                if (null !== $result->getId()) {
                    $partOfLanguage = $word->getProperty('part_of_language');

                    if (in_array($partOfLanguage, ['іменник', 'чоловіче ім`я', 'жіноче ім`я'])) {
                        $capitalWord->firstOrNewByWordBinary($textWord);
                        $capitalWord->updateProperty('is_capital', PDO::PARAM_BOOL, true);
                        echo '+';
                    }
                }
            }

            $firstLetter = mb_substr($textWord, 0, 1);

            if (in_array($firstLetter, $capitalLetters)) {

                $capitalWord->firstOrNewByWordBinary($textWord);
                echo '+';
            }
        }
    }
}






