<?php

// @acton: php slovnyk_ua_dictionary_html.php

require_once('../support/_require_once.php');

// *** //

for ($i = 1384215; $i < 2186922;  $i++) {
    echo $i;
    $htmlObj = new HtmlData($dbh);
    $htmlObj->getByHtmlId($i);

    $word = $htmlObj->getProperty('word_binary');

    if (null != $word) {
        $wordOjb = new Word($dbh);
        $wordOjb->getByWordBinary($word);

        $id = $wordOjb->getId();

        if (null === $id) {
            echo ' 0';
            $htmlObj->updateProperty('is_from_dictionary', PDO::PARAM_BOOL, 0);
        } else {
            echo ' 1';
            $htmlObj->updateProperty('is_from_dictionary', PDO::PARAM_BOOL, 1);
        }
    }

    echo ' : ';
}



