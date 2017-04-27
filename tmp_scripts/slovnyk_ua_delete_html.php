<?php

// @acton: php slovnyk_ua_delete_html.php

require_once('../support/_require_once.php');

// *** //

for ($i = 1629290; $i < 2186922;  $i++) {
    echo $i;
    $htmlObj = new HtmlData($dbh);
    $htmlObj->getByHtmlId($i);

    $word = $htmlObj->getProperty('word_binary');

    if (null != $word) {
        $wordOjb = new WordRaw($dbh);
        $wordOjb->getByWordBinary($word);

        $id = $wordOjb->getId();

        if (null === $id) {
            echo ' 0';
            $htmlObj->updateProperty('is_has_raw', PDO::PARAM_BOOL, 0);
        } else {
            echo ' 1';
            $htmlObj->updateProperty('is_has_raw', PDO::PARAM_BOOL, 1);
        }
    }

    echo ' : ';
}



