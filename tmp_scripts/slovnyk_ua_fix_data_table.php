<?php

// @acton: php slovnyk_ua_fix_data_table.php

require_once('../support/_require_once.php');

echo "\n";

for ($i = 1; $i < 194664;  $i++) {
    echo $i . ' :: ';

    $data = new SlovnykUaData($dbh);
    $data->getById($i);

    $htmlObj = new SlovnykUaHtml($dbh);
    $htmlObj->getByWordBinary($data->getWordBinary());

    if (null === $htmlObj->getProperty('word_binary')) {

    } else {
        $sql = 'UPDATE `slovnyk_ua_html` SET data_id = :id where word_binary = :word_binary limit 1;';
        $stm = $dbh->prepare($sql);
        $stm->bindParam(':id', $i, PDO::PARAM_INT);
        $stm->bindParam(':word_binary', $data->getWordBinary(), PDO::PARAM_STR);
        $stm->execute();
    }

    $htmlObj->getByWordBinary($data->getWordBinary());

    $isHtmlCutNull = (null == $htmlObj->getProperty('html_cut'));
    $isHtmlNull = (null == $htmlObj->getProperty('html'));

    if ($isHtmlNull) {
        $data->updateProperty('is_has_html', PDO::PARAM_BOOL, 0);
    } else {
        $data->updateProperty('is_has_html', PDO::PARAM_BOOL, 1);
    }

    if ($isHtmlCutNull) {
        $data->updateProperty('is_has_html_cut', PDO::PARAM_BOOL, 0);
    } else {
        $data->updateProperty('is_has_html_cut', PDO::PARAM_BOOL, 1);
    }
}



