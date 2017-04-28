<?php

// @acton: php slovnyk_ua_handle_conjunction.php     Сполучнік

require_once('../support/_require_once.php');

$part_of_language = 'сполучник';


$SlovnykUaDataC = new SlovnykUaData($dbh);
$counter = $SlovnykUaDataC->countPartOfLanguage('%'.$part_of_language.'%', ' LIKE ');
$counter = intval($counter/100) + 1;

echo "\n";
var_dump($counter);

for ($j = 0; $j < $counter;  $j++) {
    $SlovnykUaData = new SlovnykUaData($dbh);
    $allSlovnykUaData = $SlovnykUaData->getPartOfLanguage('%' . $part_of_language . '%', 100, 0, 'LIKE');

    echo "\n$j<";

    foreach ($allSlovnykUaData as $dataArray) {
        $dataId = array_get($dataArray, 'id');

        $data = new SlovnykUaData($dbh);
        $data->getById($dataId);

        $html = new SlovnykUaHtml($dbh);
        $html->getByDataId($dataId);

        // load extracted HTML=page
        $word = trim(cleanCyrillic($html->getProperty('word')));
        $text = cleanCyrillic($html->getProperty('html_cut'));

        if (' ' == $word || empty($word)) {
            $data->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
            echo '.';
            continue;
        }

        $result = new SlovnykUaResults($dbh);
        $result->firstOrNewTotal(trim($word), $part_of_language, '-', '-', '-', '-', '-', '-',
            '-', '-', '-', '-', '-', '-', 0, true, '-');
        $result->updateProperty('data_id', PDO::PARAM_INT, $dataId);
        $result->updateProperty('main_form_id', PDO::PARAM_INT, $result->getId());
        echo '+';

        $data->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
    }
    echo ">\n";
}

$SlovnykUaDataC->backHtmlRowsToProcessing();

echo 'END';




