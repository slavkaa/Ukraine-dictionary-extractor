<?php

// @link: http://phpfaq.ru/pdo
// @acton: php word_raw_check.php

require_once('../support/_require_once.php');

// *** //
function checkWordRaw($dbh, $numbers, $foreignLetters)
{
    time_nanosleep(0, 100000000);

    $wordRaw = new WordRaw($dbh);
    $wordRaw->getFirstToProcess();

    if ($wordRaw->isNew()) {
        echo "\nThere are no records to process.";
        die;
    }

    $word_binary = $wordRaw->getProperty('word_binary');
    $word_id = $wordRaw->getProperty('id');
    $is_from_dictionary = $wordRaw->getProperty('is_from_dictionary');

    if ($is_from_dictionary) {
//        echo "D";
        // nothing
    } else {

        if (isUkrainianWord($word_binary)) {
//            echo "U";
            // nothing
        } else {
            echo sprintf('!!! %s (%s).  %s', $word_binary, $word_id, "\n");

            $wordRaw->updateProperty('is_not_urk_word', PDO::PARAM_BOOL, 1);
            $wordRaw->updateProperty('is_need_processing', PDO::PARAM_BOOL, 0);

            checkWordRaw($dbh, $numbers, $foreignLetters); // =>
        }

        echo sprintf('[+] %s (%s). %s', $word_binary, $word_id, "\n");
    }

    $wordRaw->updateProperty('is_need_processing', PDO::PARAM_BOOL, 0);

    checkWordRaw($dbh, $numbers, $foreignLetters); // =>
}

checkWordRaw($dbh, $numbers, $foreignLetters);
echo "END";


