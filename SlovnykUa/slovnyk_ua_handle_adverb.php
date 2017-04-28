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

//        var_dump($dataId);

        $data = new SlovnykUaData($dbh);
        $data->getById($dataId);

        $html = new SlovnykUaHtml($dbh);
        $html->getByDataId($dataId);

        // load extracted HTML=page
        $word = trim(cleanCyrillic($html->getProperty('word')));
        $text = cleanCyrillic($html->getProperty('html_cut'));
        $partOfLanguage = $html->getProperty('part_of_language');

        if (-1 < strpos($partOfLanguage, 'дієприслівник')) {
            echo '.';
            $html->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
            continue;
        }

        if (-1 < strpos($partOfLanguage, 'дієслово')) {
            echo '.';
            $html->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
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
            '-', '-', '-', '-', '-', '-', 0, true, '-', $dictionaryId);

        $result->updateProperty('data_id', PDO::PARAM_INT, $dataId);
        $result->updateProperty('main_form_id', PDO::PARAM_INT, $result->getId());

        $data->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
    }
    echo '>';
    echo "\n";
}

$SlovnykUaDataC->backHtmlRowsToProcessing();

echo 'END';



