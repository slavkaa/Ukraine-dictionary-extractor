<?php

// @acton: php init_slovnyk_ua_data_from_word_raw.php

require_once('../support/_require_once.php');

// *** //
// select MAX(id) from slovnyk_ua_data; -- 345309
$SlovnykUaDataC = new SlovnykUaData($dbh);
$SlovnykUaDataC->resetProcessing();

$dictionary = new Dictionary($dbh);
$dictionary->firstOrNew('slovnyk.ua', 'http://www.slovnyk.ua/?swrd=');
$dictionaryId = (int) $dictionary->getProperty('id');

// word_raw MAX(id) = 246775
$WordRawObj = new WordRaw($dbh);
$counter = $WordRawObj->countIsNeedProcessing();
$counter = intval($counter/100) + 1;

echo "\n";
var_dump($counter);

for ($i = 1; $i < $counter;  $i++) {
    echo $i . '00. ';

    $wordRaw = new WordRaw($dbh);
    $allWords = $wordRaw->getAllIsNeedProcessing(100);

    foreach ($allWords as $wordArr) {
        echo '<';

        $wordId = (int) array_get($wordArr, 'id');
        $word_binary = array_get($wordArr, 'word_binary');

        $wordRawObj = new WordRaw($dbh);
        $wordRawObj->getById($wordId);

        $wordFromDictionary = new Word($dbh);
        $wordFromDictionary->getByWordBinary($word_binary);

        if ($wordFromDictionary->isNew()) {
            $data = new SlovnykUaData($dbh);
            $data->firstOrNewByWordBinary($word_binary);

            $is_in_results = (boolean) $data->getProperty('is_in_results', false);
            $is_no_data_on_slovnyk_ua = (boolean) $data->getProperty('is_no_data_on_slovnyk_ua', false);

            if ($is_in_results || $is_no_data_on_slovnyk_ua) {
                echo 'd';
                $data->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
            } else {
                echo 'n';
                $data->updateProperty('is_need_processing', PDO::PARAM_BOOL, true);
            }
        } else {
            echo 'e';
            // do nothing. Word is already in slovnyk.ua results table
        }

        $wordRawObj->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);

        echo '>';
    }
    echo "\n";
}



