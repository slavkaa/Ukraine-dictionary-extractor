<?php

// @link: http://phpfaq.ru/pdo
// @acton: php slovnyk_ua_do_cut_html.php

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

    foreach ($allHtml as $htmlArray) {
        $html = new Html($dbh);
        $html->getById(array_get($htmlArray, 'id'));

        // load extracted HTML=page
        $text = $html->getProperty('html');
        $text = iconv(mb_detect_encoding($text, mb_detect_order(), true), "UTF-8", $text);

        // init HTML parser
        $doc = new DOMDocument();
        $doc->encoding = 'UTF-8';
        @$doc->loadHTML(mb_convert_encoding($text, 'HTML-ENTITIES', 'UTF-8'));

        // extract table
        $xpath = new DOMXpath($doc);
        /** @var DOMNodeList $partOfLanguageData */
        $partOfLanguageData = $xpath->query("//*[contains(@class, 'sfm_table')]");
        $partOfLanguageData = $xpath->query("//*[contains(@class, 'bluecontent')]");

        // combine mini-HTML
        $element = $partOfLanguageData->item(1);

        if (NULL === $element) {
            echo 'NULL ';
            continue;
        }

        $newDoc = new DOMDocument();
        $doc->encoding = 'UTF-8';
        $cloned = $element->cloneNode(TRUE);
        $newDoc->appendChild($newDoc->importNode($cloned, TRUE));

        // update html_cut
        $html->updateHtmlCut(html_entity_decode($newDoc->saveHTML()));
        $html->updateIsNeedProcessing(false);
    }
}


