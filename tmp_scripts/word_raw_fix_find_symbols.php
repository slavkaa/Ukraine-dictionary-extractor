<?php

// Шукав нові символи селед слів word_raw, ті яки мо поки не відфільтровуємо.
// @acton: php word_raw_fix_find_symbols.php

require_once('../support/_require_once.php');

// *** //

$obj = new WordRaw2($dbh);
$counter = $obj->countIsNeedProcessing();
$counter = intval($counter/100) + 1;
var_dump($counter);

echo "\n";

for ($i = 1; $i < $counter;  $i++) {
    $wordObj = new WordRaw2($dbh);
    $allWords = $wordObj->getAllIsNeedProcessing(100);

    echo $i . '00. ';

    foreach ($allWords as $wordArr) {
        echo '.';
        $word_id = array_get($wordArr, 'id');

        $wordRaw = new WordRaw2($dbh);
        $wordRaw->getById($word_id);

        $wordBinary = $wordRaw->getProperty('word_binary');

        $wordBinary = str_replace($foreignLetters, '', $wordBinary);
        $wordBinary = str_replace($foreignLetters, '', $pronunciationSings);

        $wordBinary = str_replace($ukraineAbc, '', $wordBinary);
        $wordBinary = str_replace(['-'], '', $wordBinary);

        $wordRaw->updateProperty('word_binary', PDO::PARAM_STR, $wordBinary);
        $wordRaw->updateProperty('word', PDO::PARAM_STR, $wordBinary);

        $wordRaw->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
    }

    echo "\n";
}



