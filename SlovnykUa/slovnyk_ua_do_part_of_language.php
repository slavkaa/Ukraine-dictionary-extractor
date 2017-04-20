<?php

// @link: http://phpfaq.ru/pdo
// @acton: php slovnyk_ua_do_part_of_language.php

require_once('../support/config.php');
require_once('../support/functions.php');
require_once('../support/libs.php');
require_once('../models/word.php');
require_once('../models/wordToIgnore.php');
require_once('../models/source.php');
require_once('../models/dictionary.php');
require_once('../models/html.php');

// *** //

echo "\n";

for ($i = 1; $i < 120;  $i++) {
    echo $i . '00 ';
    $htmlObj = new Html($dbh);
    $allHtml = $htmlObj->getAllIsNeedProcessing(100);

    foreach ($allHtml as $htmlArray) {
        $html = new Html($dbh);
        $html->getById(array_get($htmlArray, 'id'));

        // load extracted HTML=page
        $word = $html->getProperty('word');
        $text = $html->getProperty('html_cut');
        $text = iconv(mb_detect_encoding($text, mb_detect_order(), true), "UTF-8", $text);

        $text = str_replace('<div class="bluecontent_right"> <div id="comp_be74f5e0444f5a5529f9a04de9a4b6b5"></div></div>', '', $text);
        $text = trim($text);

        // Слово може одночасно належати кільком частинам мови
        $result = [];

        if ('' === $text) { // empty response from slovnyk.ua
            echo 'e';
            $html->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
            continue;
        }

        echo '.';

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
        $html->updateProperty('part_of_language', PDO::PARAM_STR, implode(',', $result));
        $html->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
    }

    echo "\n";
}

echo 'END';

