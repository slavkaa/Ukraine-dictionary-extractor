<?php

// @acton: php slovnyk_ua_handle_particle.php     Частка

require_once('../support/_require_once.php');

$part_of_language = 'частка';

$SlovnykUaDataC = new SlovnykUaData($dbh);
$counter = $SlovnykUaDataC->countPartOfLanguage('%'.$part_of_language.'%', ' LIKE ');
$counter = intval($counter/100) + 1;

echo "\n";
var_dump($counter);

for ($j = 0; $j < $counter;  $j++) {
    $SlovnykUaData = new SlovnykUaData($dbh);
    $allSlovnykUaData = $SlovnykUaData->getPartOfLanguage('%' . $part_of_language . '%', 100, 0, 'LIKE');

    echo "\n($j+1)";

    foreach ($allSlovnykUaData as $dataArray) {
        echo '<';

        $dataId = array_get($dataArray, 'id');

        $data = new SlovnykUaData($dbh);
        $data->getById($dataId);

        $html = new SlovnykUaHtml($dbh);
        $html->getByDataId($dataId);

        // load extracted HTML=page
        $word = $data->getWordBinary();

        if (' ' == $word || empty($word)) {
            $data->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
            echo '.';
            continue;
        }

        if (0 < strpos($word, ',')) {
            die($word);
        }

        $result = new SlovnykUaResults($dbh);
        $result->firstOrNewTotal(trim($word), $part_of_language, '-', '-', '-', '-', '-', '-',
            '-', '-', '-', '-', '-', '-', 0, true, '-', $dictionaryId);
        $result->updateProperty('data_id', PDO::PARAM_INT, $dataId);
        $result->updateProperty('main_form_code', PDO::PARAM_STR, $mainFormCodePrefix . $result->getId());
        echo '+';

        $data->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
        $data->updateProperty('is_in_results', PDO::PARAM_BOOL, true);
        echo '>';
    }
    echo "\n";
}

$SlovnykUaDataC->backHtmlRowsToProcessing();

echo 'END';


