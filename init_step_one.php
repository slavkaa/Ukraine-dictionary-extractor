<?php

// @link: http://phpfaq.ru/pdo
// @acton: php builder.php

require_once('support/config.php');
require_once('support/functions.php');
require_once('support/libs.php');
require_once('models/word.php');
require_once('models/wordToIgnore.php');
require_once('models/source.php');
require_once('models/wordToSource.php');

// *** //

$author = ''; // Іван Франко
$titles = [
    '',
];

foreach ($titles as $title) {
    $filename = sprintf('%s/%s', $author, $title);
    $text = file_get_contents($filename);

    $text = iconv(mb_detect_encoding($text, mb_detect_order(), true), "UTF-8", $text); // back to cyryllic
    $text = str_replace($pronunciationSings, ' ', $text); // remove pronunciation sings
    $textWords = array_unique(explode(' ', $text)); // remove word dublicates

    foreach ($textWords as $textWord) {
        $firstLetter = mb_substr($textWord, 0, 1);

        $isCapital = in_array($firstLetter, $capitalLetters);
        $isForeign = array_in_string($foreignLetters, $textWord);
        $hasNumber = array_in_string([0,1,2,3,4,5,6,7,8,9], $textWord);

        $wordToIgnore = null;

        $source = new Source($dbh);
        $source->firstOrNew($author, $title);

        if ($isCapital || $isForeign || $hasNumber || '' == $textWord) {
            $wordToIgnore = new WordToIgnore($dbh);
            $wordToIgnore->firstOrNew($textWord, $source->getProperty('id'));
        } else {
            /** @var Word $word */
            $word = new Word($dbh);
            $word->firstOrNew($textWord);

            $wordToSource = new WordToSource($dbh);
            $wordToSource->firstOrNew($source->getProperty('id'), $word->getProperty('id'));
        }
    }
}



