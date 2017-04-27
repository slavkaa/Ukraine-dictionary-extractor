<?php

// @acton: php word_raw_fix_i.php

require_once('../support/_require_once.php');

// *** //

echo "\n";

for ($i = 1; $i < 170;  $i++) {
    $wordObj = new WordRaw($dbh);
    $allWords = $wordObj->getAllIsNeedProcessing(100);

    echo $i . '00. ';

    foreach ($allWords as $wordArr) {
        $word_id = array_get($wordArr, 'id');

        $wordRaw = new WordRaw($dbh);
        $wordRaw->getById($word_id);

        $wordBinary = $wordRaw->getProperty('word_binary');
        $wordBinary = str_replace($pronunciationSings, '', $wordBinary);
        $wordBinary = cleanCyrillic($wordBinary);

        if (array_in_string($foreignLetters, $wordBinary)) {
            echo '-';
            $wordRaw->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
            continue;
        } else {
            echo $wordBinary[0] . ','; die;
            $wordRaw->updateProperty('word', PDO::PARAM_STR, $wordBinary);
            $wordRaw->updateProperty('word_binary', PDO::PARAM_STR, $wordBinary);
        }

        $wordRaw->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
    }

    echo "\n";
}



