<?php

// @link: http://phpfaq.ru/pdo
// @acton: php slovnyk_ua_handle_adverb.php     Прислівник

require_once('../support/config.php');
require_once('../support/functions.php');
require_once('../support/libs.php');
require_once('../models/word.php');
require_once('../models/wordToIgnore.php');
require_once('../models/source.php');
require_once('../models/dictionary.php');
require_once('../models/html.php');

// *** //
$dictionary = new Dictionary($dbh);
$dictionary->firstOrNew('slovnyk.ua', 'http://www.slovnyk.ua/?swrd=');
$dictionaryId = (int) $dictionary->getProperty('id');

$part_of_language = 'прислівник';

$htmlObj = new Html($dbh);
$counter = $htmlObj->countPartOfLanguage('%'.$part_of_language.'%', ' LIKE ');
$counter = intval($counter/100) + 1;

echo "\n";

for ($j = 0; $j < $counter;  $j++) {
    $htmlObj = new Html($dbh);
    $allHtml = $htmlObj->getPartOfLanguage('%' . $part_of_language . '%', 100, 0, 'LIKE');

    echo "\n<";

    foreach ($allHtml as $htmlArray) {
        $html = new Html($dbh);
        $html->getById(array_get($htmlArray, 'id'));

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
        $htmlItem = new Html($dbh);
        $htmlItem->firstOrNewTotal(trim($word), $part_of_language, '-', '-', '-', '-', '-', '-',
            '-', '-', '-', '-', '-', '-', 0, true, '-', $dictionaryId);

        $html->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
    }
    echo '>';
    echo "\n";
}

$htmlObj->backHtmlRowsToProcessing();

echo 'END';



