<?php

// @acton: php slovnyk_ua_handle_adverb.php     Прислівник

require_once('../support/_require_once.php');

// *** //
$part_of_language = 'прислівник';

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
        $word = $data->getWordBinary();
        $text = cleanCyrillic($html->getProperty('html_cut'));
        $partOfLanguage = $html->getProperty('part_of_language');

        if (-1 < strpos($partOfLanguage, 'дієприслівник')) {
            echo '.';
            $data->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
            continue;
        }

        if (-1 < strpos($partOfLanguage, 'дієслово')) {
            echo '.';
            $data->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
            continue;
        }

        if (' ' == $word || empty($word)) {
            echo '.';
            $html->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
            continue;
        }

        echo '+';
        $result = new SlovnykUaResults($dbh);
        $result->firstOrNewTotal(trim($word), $part_of_language, '-', '-', '-', '-', '-', '-',
            '-', '-', '-', '-', '-', '-', 0, true, '-');

        $result->updateProperty('data_id', PDO::PARAM_INT, $dataId);
        $result->updateProperty('main_form_code', PDO::PARAM_STR, $mainFormCodePrefix . $result->getId());

        $data->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
        $data->updateProperty('is_in_results', PDO::PARAM_BOOL, true);
    }
    echo '>';
    echo "\n";
}

$SlovnykUaDataC->backHtmlRowsToProcessing();

echo 'END';



