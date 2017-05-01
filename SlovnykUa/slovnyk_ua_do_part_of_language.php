<?php

// @acton: php slovnyk_ua_do_part_of_language.php

require_once('../support/_require_once.php');

// *** //

$SlovnykUaDataC = new SlovnykUaData($dbh);

$SlovnykUaDataC->setDownloadedHtmlRowsToPartOfLanguageProcessing();

$counter = $SlovnykUaDataC->countIsNeedProcessing();
$counter = intval($counter/100) + 1;
echo "\n";

var_dump($counter);

for ($i = 0; $i < $counter;  $i++) {
    echo ($i+1) . '00 ';
    $obj = new SlovnykUaData($dbh);
    $allHtml = $obj->getAllIsNeedProcessing(100);

    foreach ($allHtml as $htmlArray) {
        echo '<';
        $id = array_get($htmlArray, 'id');

        $SlovnykUaData = new SlovnykUaData($dbh);
        $SlovnykUaData->getById($id);

        $SlovnykUaHtml = new SlovnykUaHtml($dbh);
        $SlovnykUaHtml->getByDataId($id);

        // load extracted HTML=page
        $text = $SlovnykUaHtml->getProperty('html_cut');
        $text = iconv(mb_detect_encoding($text, mb_detect_order(), true), "UTF-8", $text);

        $text = str_replace('<div class="bluecontent_right"> <div id="comp_be74f5e0444f5a5529f9a04de9a4b6b5"></div></div>', '', $text);
        $text = trim($text);

        // Слово може одночасно належати кільком частинам мови
        $result = [];

        if ('' === $text) { // empty response from slovnyk.ua
            echo 'e';
            $SlovnykUaData->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
            $SlovnykUaData->updateProperty('is_no_data_on_slovnyk_ua', PDO::PARAM_BOOL, true);
            echo '>';
            continue;
        }

        echo '+';

        if (0 < strpos($text, 'іменник')) {  $result[] = 'іменник';} // +
        if (0 < strpos($text, 'дієслово')) { $result[] = 'дієслово'; } // +
        if (0 < strpos($text, 'прийменник')) { $result[] = 'прийменник'; } // +
        if (0 < strpos($text, 'займенник')) { $result[] = 'займенник'; } // +
        if (0 < strpos($text, 'прикметник')) { $result[] = 'прикметник'; } // +
        if (0 < strpos($text, 'сполучник')) { $result[] = 'сполучник'; } // +
        if (0 < strpos($text, 'частка')) { $result[] = 'частка'; } // +
        if (0 < strpos($text, 'прислівник')) { $result[] = 'прислівник'; } // +
        if (0 < strpos($text, 'числівник')) { $result[] = 'числівник'; } // +
        if (0 < strpos($text, 'вигук')) { $result[] = 'вигук'; } // +
        if (0 < strpos($text, 'присудкове слово')) { $result[] = 'присудкове слово'; } // +
        if (0 < strpos($text, 'вставне слово')) { $result[] = 'вставне слово'; } // +
        if (0 < strpos($text, 'чоловіче ім\'я')) { $result[] = 'чоловіче ім\'я'; } // +
        if (0 < strpos($text, 'жіноче ім\'я')) { $result[] = 'жіноче ім\'я'; } // +

        // update html_cut
        $SlovnykUaData->updateProperty('part_of_language', PDO::PARAM_STR, implode(',', $result));

        $SlovnykUaData->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
        echo '>';
    }

    echo "\n";
}

echo 'END';

$SlovnykUaDataC->backHtmlRowsToProcessing();