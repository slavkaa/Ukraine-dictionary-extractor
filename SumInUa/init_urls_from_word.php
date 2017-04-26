<?php

// cd SumInUa
// php init_urls_from_word.php
// @acton: php SumInUa/init_urls_from_word.php

require_once('../support/_require_once.php');

// *** //

$obj = new Word($dbh);
$counter = $obj->countIsNeedProcessing();
$counter = intval($counter/100) + 1;
var_dump($counter);

echo "\n";

var_dump($counter);

for ($i = 1; $i < $counter;  $i++) {
    echo $i . '00. ';

    $word = new word($dbh);
    $allWords = $word->getAllIsNeedProcessing(100);

    foreach ($allWords as $wordArr) {
        echo '<';

        $wordId = (int) array_get($wordArr, 'id');
        $word_binary = array_get($wordArr, 'word_binary');

        $WordObj = new word($dbh);
        $WordObj->getById($wordId);

        $DataObj = new SumInUaData($dbh);
        $DataObj->firstOrNew($wordId, $word_binary);
        
        $DataObj->updateProperty('is_need_processing', PDO::PARAM_BOOL, true);

        $WordObj->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);

        echo '>';
    }
    echo "\n";
}



