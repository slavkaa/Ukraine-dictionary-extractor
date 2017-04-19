<?php

// @link: http://phpfaq.ru/pdo
// @acton: php html_set_word_id.php

require_once('support/config.php');
require_once('support/functions.php');
require_once('support/libs.php');
require_once('models/word.php');
require_once('models/wordToIgnore.php');
require_once('models/source.php');
require_once('models/dictionary.php');
require_once('models/html.php');

// *** //

for ($i = 1; $i < 179;  $i++) { //
    $wordObj = new Word($dbh);
    $allWords = $wordObj->getAllIsNeedProcessing(100);

    echo $i . '00. ';

    foreach ($allWords as $wordArr) {
        echo '.';
        $word_id = array_get($wordArr, 'id');
        $word = new Word($dbh);
        $word->getById($word_id);

        $html_id = array_get($wordArr, 'html_id');

        $html = new Html($dbh);
        $html->getById($html_id);

        if ($html->getProperty('word_id')) {
            echo '-';
        } else {
            $html->updateProperty('word_id', PDO::PARAM_INT, $word_id);
            $word->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
            echo '+';
        }
    }

    echo "\n";
}



