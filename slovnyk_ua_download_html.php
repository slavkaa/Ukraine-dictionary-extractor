<?php

// @link: http://phpfaq.ru/pdo
// @acton: php slovnyk_ua_download_html.php

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

for ($i = 1; $i < 200;  $i++) {
    echo '.';
    $htmlObj = new Html($dbh);
    $allHtml = $htmlObj->getAllIsNeedProcessing(100);

    foreach ($allHtml as $html) {
        $page = array_get($html, 'html');
//        $inp = array_get($html, 'is_need_processing');
//        var_dump($inp);

        if (NULL !== $page) {
            echo '>';
            continue;
        }

        unset($page);

        $wordId = (int) array_get($html, 'word_id');
        $url = array_get($html, 'url_binary');
        $word = array_get($html, 'word_binary');
        $dictionaryId = (int) array_get($html, 'dictionary_id');

        $htmlObj2 = new Html($dbh);
        $htmlObj2->getById(array_get($html, 'id'));

        if (null === $htmlObj2->getId()) {
            $htmlObj2->firstOrNew($wordId, $url, $word, $dictionaryId);
        }

        $page = file_get_contents($url);

        $htmlObj2->updateHtml($page);
        $htmlObj2->updateIsNeedProcessing(false);
    }

    unset($html);
    unset($htmlObj2);
    unset($allHtml);
}



