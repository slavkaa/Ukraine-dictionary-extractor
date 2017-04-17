<?php

// @link: http://phpfaq.ru/pdo
// @acton: php init_slovnyk_ua_html_urls.php

require_once('support/config.php');
require_once('support/functions.php');
require_once('support/libs.php');
require_once('models/word.php');
require_once('models/wordToIgnore.php');
require_once('models/source.php');
require_once('models/wordToSource.php');
require_once('models/dictionary.php');
require_once('models/html.php');

// *** //
$dictionary = new Dictionary($dbh);
$dictionary->firstOrNew('slovnyk.ua', 'http://www.slovnyk.ua/?swrd=');
$dictionaryId = (int) $dictionary->getProperty('id');

$word = new Word($dbh);
$allWords = $word->getAll();

foreach ($allWords as $word) {

    $wordId = (int) array_get($word, 'id');
    $word = array_get($word, 'word');
    $url = $dictionary->getProperty('base_url') . urlencode($word);

    $html = new Html($dbh);
    $html->firstOrNew($wordId, $url, $word, $dictionaryId);
    die;
}



