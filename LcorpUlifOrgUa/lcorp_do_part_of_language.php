<?php

// @acton: php lcorp_do_part_of_language.php

require_once('../support/_require_once.php');

// *** //

$LcorpDataC = new LcorpData($dbh);

$LcorpDataC->setDownloadedHtmlRowsToPartOfLanguageProcessing();

$counter = $LcorpDataC->countIsNeedPartOfLanguageProcessing();
$counter = intval($counter/100) + 1;
echo "\n";

for ($i = 0; $i < $counter;  $i++) {
    echo ($i+1) .'00/'. $counter . '00 ';
    $obj = new LcorpData($dbh);
    $allHtml = $obj->getAllIsNeedPartOfLanguageProcessing(100);

    foreach ($allHtml as $htmlArray) {
        echo '<';
        $id = array_get($htmlArray, 'id');

        $LcorpData = new LcorpData($dbh);
        $LcorpData->getById($id);

        $LcorpHtml = new LcorpHtml($dbh);
        $LcorpHtml->getByDataId($id);

        // load extracted HTML=page
        $text = $LcorpHtml->getPartOfLanguage();

        // Слово може одночасно належати кільком частинам мови


        if ('' === $text) { // empty response from slovnyk.ua
            echo 'e';
            $LcorpData->updateProperty('is_need_processing_part_of_language', PDO::PARAM_BOOL, false);
            $LcorpData->updateProperty('is_no_data_in_web', PDO::PARAM_BOOL, true);
            echo '>';
            continue;
        }

        echo '+';

//        $result = [];
//        if (0 < strpos($text, 'іменник')) {  $result[] = 'іменник';} // +
//        if (0 < strpos($text, 'дієслово')) { $result[] = 'дієслово'; } // +
//        if (0 < strpos($text, 'прийменник')) { $result[] = 'прийменник'; } // +
//        if (0 < strpos($text, 'займенник')) { $result[] = 'займенник'; } // +
//        if (0 < strpos($text, 'прикметник')) { $result[] = 'прикметник'; } // +
//        if (0 < strpos($text, 'сполучник')) { $result[] = 'сполучник'; } // +
//        if (0 < strpos($text, 'частка')) { $result[] = 'частка'; } // +
//        if (0 < strpos($text, 'прислівник')) { $result[] = 'прислівник'; } // +
//        if (0 < strpos($text, 'числівник')) { $result[] = 'числівник'; } // +
//        if (0 < strpos($text, 'вигук')) { $result[] = 'вигук'; } // +
//        if (0 < strpos($text, 'присудкове слово')) { $result[] = 'присудкове слово'; } // +
//        if (0 < strpos($text, 'вставне слово')) { $result[] = 'вставне слово'; } // +
//        if (0 < strpos($text, 'чоловіче ім\'я')) { $result[] = 'чоловіче ім\'я'; } // +
//        if (0 < strpos($text, 'жіноче ім\'я')) { $result[] = 'жіноче ім\'я'; } // +

        // update html_cut
        $LcorpData->updateProperty('part_of_language', PDO::PARAM_STR, $text);
//        $LcorpData->updateProperty('part_of_language', PDO::PARAM_STR, implode(',', $result));

        $LcorpData->updateProperty('is_need_processing_part_of_language', PDO::PARAM_BOOL, false);
        echo '>';

//        var_dump($LcorpData->getId());
//        die;
    }

    echo "\n";
}

echo 'END';

$LcorpDataC->backHtmlRowsToProcessing();