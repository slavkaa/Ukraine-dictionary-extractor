<?php

// @acton: php slovnyk_ua_handle_conjunction.php     Сполучнік

require_once('../support/_require_once.php');

$part_of_language = 'сполучник';


$SlovnykUaDataC = new SlovnykUaData($dbh);
$counter = $SlovnykUaDataC->countPartOfLanguage('%'.$part_of_language.'%', ' LIKE ');
$counter = intval($counter/100) + 1;

echo "\n";

for ($j = 0; $j < $counter;  $j++) {
    $htmlObj = new Html($dbh);
    $allHtml = $htmlObj->getPartOfLanguage('%' . $part_of_language . '%', 100, 0, 'LIKE');
    echo "$j<";

    foreach ($allHtml as $htmlArray) {
        $dataId = array_get($dataArray, 'id');

        $data = new SlovnykUaData($dbh);
        $data->getById($dataId);

        $html = new SlovnykUaHtml($dbh);
        $html->getByDataId($dataId);

        // load extracted HTML=page
        $word = trim(cleanCyrillic($html->getProperty('word')));
        $text = cleanCyrillic($html->getProperty('html_cut'));
        $partOfLanguage = $html->getProperty('part_of_language');

        if (' ' == $word || empty($word)) {
            $data->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
            echo '.';
            continue;
        }

        if ($part_of_language !== trim($partOfLanguage)) {
            $result = new SlovnykUaResults($dbh);
            $result->firstOrNewTotal(trim($word), $part_of_language, '-', '-', '-', '-', '-', '-',
                '-', '-', '-', '-', '-', '-', 0, true, '-');
            echo '+';
        } else {
            echo '.';
        }

        $data->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
        die;
    }
    echo ">\n";
}

$SlovnykUaDataC->backHtmlRowsToProcessing();

echo 'END';




