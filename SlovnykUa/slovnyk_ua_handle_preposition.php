<?php

// @link: http://phpfaq.ru/pdo
// @acton: php slovnyk_ua_handle_preposition.php          Прийменник

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

$part_of_language = 'прийменник';
echo "\n";

for ($j = 0; $j < 2;  $j++) {
    $htmlObj = new Html($dbh);
    $allHtml = $htmlObj->getPartOfLanguage('%' . $part_of_language . '%', 100, $j*100, 'LIKE');
    echo "<";

    foreach ($allHtml as $htmlArray) {
        echo '+';
        $html = new Html($dbh);
        $html->getById(array_get($htmlArray, 'id'));

        // load extracted HTML=page
        $word = trim(cleanCyrillic($html->getProperty('word')));
        $partOfLanguage = $html->getProperty('part_of_language');

        if (' ' == $word || empty($word)) {
            continue;
        }

        if ($part_of_language !== trim($partOfLanguage)) {
            $htmlItem = new Html($dbh);
            $htmlItem->firstOrNewTotal(trim($word), $part_of_language, '-', '-', '-', '-', '-', '-',
                '-', '-', '-', '-', '-', '-', 0, true, '-', $dictionaryId);
        } else {
            echo 'i';
        }
    }
    echo ">\n";
}

echo 'END';



