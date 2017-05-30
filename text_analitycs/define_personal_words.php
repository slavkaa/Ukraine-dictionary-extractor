<?php

// @acton: php define_personal_words.php

require_once('../support/_require_once.php');

require_once('config_uncapitalize/_trusted_uppercase.php');

$words = explode(' ', $list);

var_dump($words);

foreach ($words as $word) {
    echo "\n" . $word;
    $wordObj = new WordRaw($dbh);
    $wordObj->findByWord($word);

    if (false == $wordObj->isNew()) {
        $wordObj->updateProperty('is_trusted_uppercase', PDO::PARAM_BOOL, true);
        echo '+';
    } else {
        echo '-';
    }
}






