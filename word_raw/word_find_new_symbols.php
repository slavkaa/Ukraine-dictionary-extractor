<?php

// @acton: php word_find_new_symbols.php

require_once('../support/_require_once.php');

// *** //

echo "\n";

for ($i = 1; $i < 510;  $i++) {
    $wordRaw = new WordRaw($dbh);
    $allWords = $wordRaw->getAllIsNeedProcessing(100);

    echo $i . '00. ';

    foreach ($allWords as $wordArr) {
        echo '<';
        $word_id = array_get($wordArr, 'id');

        $wordRaw = new Word($dbh);
        $wordRaw->getById($word_id);

        $word_binary = $wordRaw->getProperty('word_binary');
        $word_binary = str_replace($capitalLetters, '', $word_binary);
        $word_binary = str_replace($foreignLetters, '', $word_binary);
        $word_binary = str_replace($pronunciationSings, '', $word_binary);
        $word_binary = str_replace($ukraineAbc, '', $word_binary);
        $word_binary = str_replace($numbers, '', $word_binary);
        $word_binary = str_replace(' ', '', $word_binary);
        $word_binary = str_replace("\xA0", '', $word_binary);

        if ('' != $word_binary) {
            echo htmlentities($word_binary);
        }

        $wordRaw->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
        echo '>';
    }

    echo "\n";
}



