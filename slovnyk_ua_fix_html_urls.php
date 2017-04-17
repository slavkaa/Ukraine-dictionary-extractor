<?php

// @link: http://phpfaq.ru/pdo
// @acton: php slovnyk_ua_fix_html_urls.php

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

$htmlObj = new Html($dbh);
$allHtml = $htmlObj->getAllWithUndefinedPartOfLanguage(9000);

foreach ($allHtml as $htmlX) {
    $htmlId = array_get($htmlX, 'id');

    $html = new Html($dbh);
    $html->getById($htmlId);

    $textW = $html->getProperty('word');
    $textW = str_replace(['i'], ['і'], $textW);
    $text = clearAttended($textW, $accentedLetters, $accentedLettersReplace);

    $url = $dictionary->getProperty('base_url') . urlencode($text);

    $html->updateUrl($url);
    echo '.';
}



