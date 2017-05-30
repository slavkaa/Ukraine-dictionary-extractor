<?php

// @acton: php lcorp_download_html.php

require_once('../support/_require_once.php');

function download() {
    try {
        global $dbh;

        $LcorpData = new LcorpData($dbh);
        //$LcorpData->resetProcessing();
        //$LcorpData->setDownloadingProcessing();

        $counter = $LcorpData->countIsNeedProcessing();
        $counter = intval($counter/100) + 1;
        var_dump($counter);

        echo "\n";

        for ($i = 0; $i < $counter;  $i++) {
            echo ($i+1) . '00./' . $counter . '00.';
            $dataObj = new LcorpData($dbh);
            $allData = $dataObj->getAllIsNeedProcessing(100);

                foreach ($allData as $dataArr) {
                    echo '<';

                    $id = (int) array_get($dataArr, 'id');

                    $data = new LcorpData($dbh);
                    $data->getById($id);

                    $word_binary = array_get($dataArr, 'word_binary');
                    $url = 'http://lcorp.ulif.org.ua/dictua/dictua.aspx';

                    $postdata = http_build_query(
                        array(
                            'ctl00$ContentPlaceHolder1$tsearch' => $word_binary
                        )
                    );

                    $opts = array('http' =>
                        array(
                            'method'  => 'POST',
                            'header'  => 'Content-type: application/x-www-form-urlencoded',
                            'content' => $postdata
                        )
                    );

                    $context  = stream_context_create($opts);

                    $page = file_get_contents($url, false, $context);

            //            echo '<pre>';
            //            echo $url;
            //            echo "\n";
            //            echo $word_binary;
            //            echo '</pre>';
            //            echo $page;
            //            echo '<pre>';
            //            die;

                    $htmlData = new LcorpHtml($dbh);
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
