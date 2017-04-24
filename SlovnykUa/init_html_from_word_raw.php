<?php

// @acton: php init_html_from_word_raw.php

require_once('../support/_require_once.php');

// *** //
$dictionary = new Dictionary($dbh);
$dictionary->firstOrNew('slovnyk.ua', 'http://www.slovnyk.ua/?swrd=');
$dictionaryId = (int) $dictionary->getProperty('id');

echo "\n";

for ($i = 1; $i < 290;  $i++) {
    echo $i . '00. ';

    $wordRaw = new WordRaw($dbh);
    $allWords = $wordRaw->getAllIsNeedProcessing(100);

    foreach ($allWords as $wordArr) {
        echo '<';

        $wordId = (int) array_get($wordArr, 'id');
        $word_binary = array_get($wordArr, 'word_binary');
        $url = $dictionary->getProperty('base_url') . urlencode($word_binary);


        $wordRawObj = new WordRaw($dbh);
        $wordRawObj->getById($wordId);

        if (array_in_string($numbers, $word_binary) || array_in_string($foreignLetters, $word_binary)) {
            echo 'f>';
            $wordRawObj->updateProperty('is_not_urk_word', PDO::PARAM_BOOL, true);
            $wordRawObj->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
            continue;
        } elseif (array_in_string($ukraineAbc, $word_binary)) {
            // It is OK.
        } else {
            echo 'f>';
            $wordRawObj->updateProperty('is_not_urk_word', PDO::PARAM_BOOL, true);
            $wordRawObj->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
            continue;
        }

        $html = new Html($dbh);
        $html->firstOrNew($wordId, $url, $word_binary, $dictionaryId);
        $html->updateProperty('is_need_processing', PDO::PARAM_BOOL, true);

        $wordRawObj->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);

        echo '>';
    }
    echo "\n";
}



