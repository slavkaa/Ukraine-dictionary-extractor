<?php

// @acton: php slovnyk_ua_download_html.php

require_once('../support/_require_once.php');

// *** //

echo "\n";

for ($i = 1; $i < 171;  $i++) {
    echo $i . '00.';
    $htmlObj = new Html($dbh);
    $allHtml = $htmlObj->getAllIsNeedProcessing(100);

        foreach ($allHtml as $htmlArr) {
            echo '<';

            $htmlObj2 = new Html($dbh);
            $htmlObj2->getById(array_get($htmlArr, 'id'));

            $page = file_get_contents($htmlObj2->getProperty('url_binary'));

            $htmlObj2->updateProperty('html', PDO::PARAM_LOB, $page);
            $htmlObj2->getById(array_get($htmlArr, 'id')); // refresh

            $htmlObj2->generateCutHtml();

            $htmlObj2->updateProperty('is_need_processing', PDO::PARAM_BOOL, false); // we need cut HTML after

            echo '>';
        }

    unset($htmlArr);
    unset($htmlObj2);
    unset($allHtml);
    unset($page);
    echo "\n";
}



