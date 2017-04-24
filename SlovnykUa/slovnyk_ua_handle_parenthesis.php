<?php

// @link: http://phpfaq.ru/pdo
// @acton: php slovnyk_ua_handle_parenthesis.php    Вставне слово

require_once('../support/_require_once.php');

// *** //
$dictionary = new Dictionary($dbh);
$dictionary->firstOrNew('slovnyk.ua', 'http://www.slovnyk.ua/?swrd=');
$dictionaryId = (int) $dictionary->getProperty('id');

$part_of_language = 'вставне слово';

echo "\n";

$htmlObj = new Html($dbh);
$counter = $htmlObj->countPartOfLanguage('%'.$part_of_language.'%', ' LIKE ');
$counter = intval($counter/100) + 1;

var_dump($counter);

echo "\n";

for ($j = 0; $j < $counter;  $j++) {
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
            $html->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
            continue;
        }

        if ($part_of_language !== trim($partOfLanguage)) {
            $htmlItem = new Html($dbh);
            $htmlItem->firstOrNewTotal(trim($word), $part_of_language, '-', '-', '-', '-', '-', '-',
                '-', '-', '-', '-', '-', '-', 0, true, '-', $dictionaryId);
        }
        $html->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
    }

    echo ">\n";
}

$htmlObj->backHtmlRowsToProcessing();

echo 'END';



