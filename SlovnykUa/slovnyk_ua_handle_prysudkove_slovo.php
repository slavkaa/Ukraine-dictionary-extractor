<?php

// @acton: php slovnyk_ua_handle_prysudkove_slovo.php    Присудкове слово

require_once('../support/_require_once.php');

// *** //
$dictionary = new Dictionary($dbh);
$dictionary->firstOrNew('slovnyk.ua', 'http://www.slovnyk.ua/?swrd=');
$dictionaryId = (int) $dictionary->getProperty('id');

$part_of_language = 'присудкове слово';
echo "\n";

for ($j = 0; $j < 1;  $j++) {
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
    }
    $html->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
    echo ">\n";
}

echo 'END';



