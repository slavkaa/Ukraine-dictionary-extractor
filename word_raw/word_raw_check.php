<?php

// @link: http://phpfaq.ru/pdo
// @acton: php word_raw_check.php

require_once('support/config.php');
require_once('support/functions.php');
require_once('support/libs.php');
require_once('models/wordRaw.php');

// *** //
function checkWordRaw($dbh, $handle, $numbers, $foreignLetters)
{
    time_nanosleep(0, 100000000);

    $wordRaw = new WordRaw($dbh);
    $wordRaw->getFirstToProcess();

    if ($wordRaw->isNew()) {
        echo "\nThere are no records toprocess.";
        die;
    }

    $word_binary = $wordRaw->getProperty('word_binary');
    $word_id = $wordRaw->getProperty('id');
    $is_from_dictionary = $wordRaw->getProperty('is_from_dictionary');

    if ($is_from_dictionary) {
//        echo sprintf('DIC %s (%s).  %s', $word_binary, $word_id, "\n");
        echo ".\n";
        // nothing
    } else {
        $isNumberDetected = array_in_string($numbers, $word_binary);
        $isForeignChar1 = array_in_string([
            'э','Э', 'Ъ', 'ъ', 'Ы', 'ы', 'Ё', 'ё', '“', '”', '–',
            ',','.',':',';','!','?','..','...' ,'…','№','•','^','~','#','$','%','=','+','*','@','&','|',
        ], $word_binary);
        $isForeignChar2 = array_in_string($foreignLetters, $word_binary);

        if ($isNumberDetected || $isForeignChar1 || $isForeignChar2) {
            echo sprintf('!!! %s (%s).  %s', $word_binary, $word_id, "\n");

            $wordRaw->updateProperty('is_not_urk_word', PDO::PARAM_BOOL, 1);
            $wordRaw->updateProperty('is_need_processing', PDO::PARAM_BOOL, 0);

            checkWordRaw($dbh, $handle, $numbers, $foreignLetters); // =>
        }

        echo sprintf('[+] %s (%s). %s', $word_binary, $word_id, "\n");
    }

    $wordRaw->updateProperty('is_need_processing', PDO::PARAM_BOOL, 0);

    checkWordRaw($dbh, $handle, $numbers, $foreignLetters); // =>
}

$handle = fopen ("php://stdin","r");
checkWordRaw($dbh, $handle, $numbers, $foreignLetters);
fclose($handle);
echo "END";


