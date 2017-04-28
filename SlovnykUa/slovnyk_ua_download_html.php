<?php

// @acton: php slovnyk_ua_download_html.php

require_once('../support/_require_once.php');

// *** //

$SlovnykUaData = new SlovnykUaData($dbh);
$counter = $SlovnykUaData->countIsNeedProcessing();
$counter = intval($counter/100) + 1;
var_dump($counter);

echo "\n";

for ($i = 1; $i < $counter;  $i++) {
    echo $i . '00.';
    $htmlObj = new Html($dbh);
    $allHtml = $htmlObj->getAllIsNeedProcessing(100);

        foreach ($allHtml as $htmlArr) {
            echo '<';

            $id = (int) array_get($htmlArr, 'id');
            $word = array_get($htmlArr, 'word_binary');
            $htmlObj2 = new Html($dbh);
            $htmlObj2->getById($id);

            $page = file_get_contents($htmlObj2->getProperty('url_binary'));

            $htmlData = new HtmlData($dbh);
            $htmlData->firstOrNew($id, $word);

            $htmlData->updateProperty('html', PDO::PARAM_LOB, $page);
            $htmlData->getByHtmlId($id); // refresh

            $htmlData->generateCutHtml();
            $htmlObj2->updateProperty('is_need_processing', PDO::PARAM_BOOL, false); // we need cut HTML after

            echo '>';
        }

    unset($htmlArr);
    unset($htmlObj2);
    unset($allHtml);
    unset($page);
    echo "\n";
}



