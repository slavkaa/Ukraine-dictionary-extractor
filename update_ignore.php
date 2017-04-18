<?php

// @link: http://phpfaq.ru/pdo
// @acton: php update_ignore.php

require_once('support/config.php');
require_once('support/functions.php');
require_once('support/libs.php');
require_once('models/word.php');
require_once('models/wordRaw.php');
require_once('models/wordToIgnore.php');
require_once('models/source.php');
require_once('models/wordRawToSource.php');

// *** //

$wordToIgnore = new WordToIgnore($dbh);
$stm = $wordToIgnore->getAll();

foreach ($stm as $wordArr) {
    echo '+';
    $textWord = array_get($wordArr, 'word_binary');

    $wordRaw = new WordRaw($dbh);
    $wordRaw->firstOrNew($textWord);
    $wordRaw->updateProperty('is_to_ignore', PDO::PARAM_BOOL, true);
}




