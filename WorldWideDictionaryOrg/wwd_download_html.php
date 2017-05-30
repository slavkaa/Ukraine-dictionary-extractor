<?php

// @acton: php wwd_download_html.php

require_once('../support/_require_once.php');

function download() {
    try {
        global $dbh;

        $WwdData = new WwdData($dbh);
        $WwdData->resetProcessing();
        $WwdData->setDownloadingProcessing();

        $counter = $WwdData->countIsNeedProcessing();
        $counter = intval($counter/100) + 1;
        var_dump($counter);

        echo "\n";

        for ($i = 0; $i < $counter;  $i++) {
            echo ($i+1) . '00./' . $counter . '00.';
            $dataObj = new WwdData($dbh);
            $allData = $dataObj->getAllIsNeedProcessing(100);

                foreach ($allData as $dataArr) {
                    echo '<';

                    $id = (int) array_get($dataArr, 'id');

                    $data = new WwdData($dbh);
                    $data->getById($id);

                    $word_binary = array_get($dataArr, 'word_binary');
                    $url = 'https://uk.worldwidedictionary.org/' . urlencode($word_binary);

                    $page = file_get_contents($url);

        //            echo $url;
        //            echo "\n";
        //            echo $word_binary;
        //            echo $page;
        //            die;

                    $htmlData = new WwdHtml($dbh);
                    $htmlData->firstOrNew($id, $word_binary);

                    echo '.';

                    $htmlData->getByDataId($id); // refresh
                    $htmlData->generateCutHtml($page);

                    $data->updateProperty('is_has_html', PDO::PARAM_BOOL, true); // we need cut HTML after
                    $data->updateProperty('is_need_processing', PDO::PARAM_BOOL, false); // we need cut HTML after

                    echo '>';
                }

            unset($dataArr);
            unset($dataObj2);
            unset($allData);
            unset($page);
            echo "\n";
        }
    } catch (Exception $e) {
        download();
    }
}


download();