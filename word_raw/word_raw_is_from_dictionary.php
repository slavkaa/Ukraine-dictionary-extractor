<?php

// @link: http://phpfaq.ru/pdo
// @acton: php word_raw_is_from_dictionary.php

require_once('support/config.php');
require_once('support/functions.php');
require_once('support/libs.php');
require_once('models/word.php');
require_once('models/wordToIgnore.php');
require_once('models/source.php');
require_once('models/dictionary.php');
require_once('models/html.php');

// *** //

for ($i = 1; $i < 2704;  $i++) {
    $wordObj = new Word($dbh);
    $allWords = $wordObj->getAllIsNeedProcessing(100);

    echo $i . '00. ';

    foreach ($allWords as $wordArr) {
        $word_id = array_get($wordArr, 'id');
        $word = new Word($dbh);
        $word->getById($word_id);

        $wordBinary = array_get($wordArr, 'word_binary');

        $sql = 'UPDATE `word_raw` SET is_from_dictionary = 1 WHERE word_binary = :word;';
        $stm = $dbh->prepare($sql);
        $stm->bindParam(':word', $wordBinary, PDO::PARAM_STR);
        $stm->execute();

        $word->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
        echo '.';
    }

    echo "\n";
}



