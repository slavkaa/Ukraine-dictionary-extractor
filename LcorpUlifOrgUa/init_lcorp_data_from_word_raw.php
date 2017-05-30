<?php

// @acton: php init_lcorp_data_from_word_raw.php

require_once('../support/_require_once.php');

// *** //
// select MAX(id) from
$DataC = new LcorpData($dbh);
$DataC->resetProcessing();

$dictionary = new Dictionary($dbh);
$dictionary->firstOrNew('lcorp.ulif.org.ua', 'http://lcorp.ulif.org.ua/dictua/');
$dictionaryId = (int) $dictionary->getProperty('id');

$WordRawObj = new WordRaw($dbh);
$WordRawObj->resetProcessing();

$dbh->query('UPDATE `word_raw` SET is_need_processing = 1;'); // ALL
//$dbh->query('update word_raw set is_need_processing = 1 where id = 30005');

$counter = $WordRawObj->countIsNeedProcessing();
$counter = intval($counter/100) + 1;

echo "\n";
var_dump($counter);

for ($i = 0; $i < $counter;  $i++) {
    echo ($i+1) . '00/' . $counter . '00. ';

    $wordRaw = new WordRaw($dbh);
    $allWords = $wordRaw->getAllIsNeedProcessing(100);

    foreach ($allWords as $wordArr) {
        echo '<';

        $wordId = (int) array_get($wordArr, 'id');
        $word_binary = array_get($wordArr, 'word_binary');

        $wordRawObj = new WordRaw($dbh);
        $wordRawObj->getById($wordId);

        $wordFromDictionary = new LcorpWord($dbh);
        $wordFromDictionary->getByWordBinary($word_binary);

        if ($wordFromDictionary->isNew()) {
            $data = new LcorpData($dbh);
            $data->firstOrNewByWordBinary($word_binary);

            $is_in_results = (boolean) $data->getProperty('is_in_results', false);
            $is_no_data_in_web = (boolean) $data->getProperty('is_no_data_in_web', false);

            if ($is_in_results || $is_no_data_in_web) {
                echo 'd';
                $data->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
            } else {
                echo 'n';
                $data->updateProperty('is_need_processing', PDO::PARAM_BOOL, true);
                $data->updateProperty('is_need_downloading', PDO::PARAM_BOOL, true);
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



