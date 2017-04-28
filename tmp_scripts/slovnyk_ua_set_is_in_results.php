<?php

// @acton: php slovnyk_ua_set_is_in_results.php

require_once('../support/_require_once.php');

// *** //

for ($i = 1; $i < 345309;  $i++) {
    echo $i;
    $SlovnykUaData = new SlovnykUaData($dbh);
    $SlovnykUaData->getById($i);

    $word = $SlovnykUaData->getProperty('word_binary');

    if (null != $word) {
        $wordOjb = new Word($dbh);
        $wordOjb->getByWordBinary($word);

        $id = $wordOjb->getId();

        if (null === $id) {
            echo ' 0';
            $SlovnykUaData->updateProperty('is_in_results', PDO::PARAM_BOOL, 0);
        } else {
            echo ' 1';
            $SlovnykUaData->updateProperty('is_in_results', PDO::PARAM_BOOL, 1);
        }
    }

    echo ' : ';
}



