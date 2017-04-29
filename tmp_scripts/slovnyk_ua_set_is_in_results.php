<?php

// @acton: php slovnyk_ua_set_is_in_results.php

require_once('../support/_require_once.php');

$SlovnykUaDataC = new SlovnykUaData($dbh);
$counter = $SlovnykUaDataC->countIsNeedProcessing();
$counter = intval($counter/100) + 1;

echo "\n";
var_dump($counter);

for ($j = 0; $j < $counter;  $j++) {
    echo $i;

    $d = new SlovnykUaData($dbh);
    $allWords = $d->getAllIsNeedProcessing(100);

    foreach ($allWords as $wordArr) {
        $SlovnykUaData = new SlovnykUaData($dbh);
        $SlovnykUaData->getById(array_get($wordArr, 'id'));

        $word = $SlovnykUaData->getProperty('word_binary');

        if (null != $word) {
            $wordOjb = new SlovnykUaResults($dbh);
            $wordOjb->getByDataId(array_get($wordArr, 'id'));

            $id = $wordOjb->getId();

            if (null !== $id) {
                echo ' 1';
                $SlovnykUaData->updateProperty('is_in_results', PDO::PARAM_BOOL, 1);
            }

            $SlovnykUaData->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
        }

        echo ' : ';
    }
}

$SlovnykUaDataC->backHtmlRowsToProcessing();



