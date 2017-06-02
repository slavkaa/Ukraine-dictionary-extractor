<?php

// @acton: php lcorp_clean_results.php

require_once('../support/_require_once.php');

$LcorpResults = new LcorpResults($dbh);
//$LcorpResults->setAllToProcessing();

$counter = $LcorpResults->countIsNeedProcessing();
$counter = intval($counter/100) + 1;

echo "\n";
var_dump($counter);
echo "\n";

for ($j = 0; $j < $counter + 1;  $j++) {
    $allLcorpData = $LcorpResults->getAllIsNeedProcessing(100, 0);

    foreach ($allLcorpData as $dataArray) {

        $dataId = array_get($dataArray, 'id');

        $LcorpResult = new LcorpResults($dbh);
        $LcorpResult->getById($dataId);

        $word = $LcorpResult->getProperty('word');
        $word = clearAttended($word, $accentedLetters, $accentedLettersReplace);
        $word = str_replace($numbers, '', $word);
        $word = str_replace(['*'], '', $word);
        $word = str_replace('i', 'і', $word);
        $word = str_replace(" ", ' ', $word);
        $word = str_replace('\'', '`', $word);
        if ('у ' === mb_substr($word, 0, 2)) {
            $word = mb_substr($word, 1);
        }
        if ('по ' === mb_substr($word, 0, 3)) {
            $word = mb_substr($word, 2);
        }
        if ('на ' === mb_substr($word, 0, 3)) {
            $word = mb_substr($word, 2);
        }
        if ('при ' === mb_substr($word, 0, 4)) {
            $word = mb_substr($word, 3);
        }
        if ('на/в ' === mb_substr($word, 0, 5)) {
            $word = mb_substr($word, 4);
        }
        $word = trim($word);

        $accented = $LcorpResult->getProperty('accented');
        $accented = str_replace('í', 'і́', $accented);
        $accented = str_replace('i', 'і', $accented);
        $accented = str_replace(" ", ' ', $accented);
        $accented = str_replace('\'', '`', $accented);
        $accented = str_replace($numbers, '', $accented);
        $accented = str_replace(['*'], '', $accented);
        if ('у ' === mb_substr($accented, 0, 2)) {
            $accented = mb_substr($accented, 1);
        }
        if ('на ' === mb_substr($accented, 0, 3)) {
            $accented = mb_substr($accented, 2);
        }
        if ('по ' === mb_substr($accented, 0, 3)) {
            $accented = mb_substr($accented, 2);
        }
        if ('при ' === mb_substr($accented, 0, 4)) {
            $accented = mb_substr($accented, 3);
        }
        if ('на/в ' === mb_substr($accented, 0, 5)) {
            $accented = mb_substr($accented, 4);
        }
        $accented = trim($accented);

        $wordClean = str_replace($ukraineAbc, '', $word);
        $wordClean = trim ($wordClean);

        $accentedClean = clearAttended($accented, $accentedLetters, $accentedLettersReplace);
        $accentedClean = str_replace($ukraineAbc, '', $accentedClean);
        $accentedClean = trim($accentedClean);

        if ('' != $wordClean || '' != $accentedClean) {
            var_dump($dataId);
            var_dump($word);
            var_dump($wordClean);
            var_dump($accented);
            var_dump($accentedClean);
            die;
        } else {
            $LcorpResult->updateProperty('word', PDO::PARAM_STR, $word);
            $LcorpResult->updateProperty('word_binary', PDO::PARAM_STR, $word);

            $LcorpResult->updateProperty('accented', PDO::PARAM_STR, $accented);
            $LcorpResult->updateProperty('accented_binary', PDO::PARAM_STR, $accented);

            $LcorpResult->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);

            echo '+';
        }
    }
}