<?php

// @link: http://phpfaq.ru/pdo
// @acton: php word_raw_is_html_loaded.php

require_once('support/config.php');
require_once('support/functions.php');
require_once('support/libs.php');
require_once('models/word.php');
require_once('models/wordToIgnore.php');
require_once('models/source.php');
require_once('models/dictionary.php');
require_once('models/html.php');

// *** //

for ($i = 1; $i < 3210;  $i++) { //
    $htmlObj = new Html($dbh);
    $allHtmls = $htmlObj->getAllIsNeedProcessing(100);

    echo $i . '00. ';

    foreach ($allHtmls as $htmlArr) {
        $html_id = array_get($htmlArr, 'id');
        $html = new Html($dbh);
        $html->getById($html_id);

        $wordBinary = array_get($htmlArr, 'word_binary');

        $sql = 'UPDATE `word_raw` SET is_html_loaded = 1 WHERE word_binary = :word;';
        $stm = $dbh->prepare($sql);
        $stm->bindParam(':word', $wordBinary, PDO::PARAM_STR);
        $stm->execute();

        $html->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
        echo '.';
    }

    echo "\n";
}



