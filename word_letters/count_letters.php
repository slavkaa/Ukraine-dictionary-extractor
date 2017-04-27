<?php

// cd SumInUa
// php count_letters.php

require_once('../support/_require_once.php');

// *** //

$obj = new WordLetters($dbh);
$counter = $obj->countIsNeedProcessing();
$counter = intval($counter/100) + 2;
var_dump($counter);

echo "\n";

var_dump($counter);

for ($i = 1; $i < $counter;  $i++) {
    echo $i . '00. ';

    $word = new WordLetters($dbh);
    $allWords = $word->getAllIsNeedProcessing(100);

    foreach ($allWords as $wordArr) {
        $wordId = (int) array_get($wordArr, 'word_id');
        $word_binary = array_get($wordArr, 'word_binary');

//        var_dump($wordId);

        $WordObj = new wordLetters($dbh);
        $WordObj->getByWordId($wordId);
        $word = $WordObj->getProperty('word_binary');
        $word = str_replace($ukraineAbc, '', $word);

//        if ('' !== trim($word)) {
//            var_dump($word, $wordId, htmlentities($word));
//        }
        $WordObj->updateLength();
        $WordObj->updateLetterPlaces();
        $WordObj->updateLetterCounter();

        $WordObj->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);

        echo '.';
    }
    echo "\n";
}



