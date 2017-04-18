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

for ($j = 0; $j < 140;  $j++) {
    echo '.';
    $htmlObj = new Html($dbh);
    $allHtml = $htmlObj->getPartOfLanguage('%' . $part_of_language . '%', 100, $j*100, 'LIKE');

    foreach ($allHtml as $htmlArray) {
        echo '+';
        $html = new Html($dbh);
        $html->getById(array_get($htmlArray, 'id'));

//        echo 'InitId(' . array_get($htmlArray, 'id') . ')';

        // load extracted HTML=page
        $word = cleanCyrillic($html->getProperty('word'));
        $text = cleanCyrillic($html->getProperty('html_cut'));
        $partOfLanguage = $html->getProperty('part_of_language');

        if (-1 < strpos($partOfLanguage, 'дієприслівник')) {
            continue;
        }

        if (-1 < strpos($partOfLanguage, 'дієслово')) {
            continue;
        }

        if ($part_of_language !== trim($partOfLanguage)) {
            $html->firstOrNewAdverb($word, $dictionaryId);
            $html->updateProperty('is_main_form', PDO::PARAM_BOOL, true);
        }

        $html->updateProperty('is_main_form', PDO::PARAM_BOOL, true);
    }
}

echo 'END';



