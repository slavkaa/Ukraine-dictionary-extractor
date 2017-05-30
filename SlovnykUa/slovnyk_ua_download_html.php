<?php

// @acton: php slovnyk_ua_download_html.php

require_once('../support/_require_once.php');

// *** //

$SlovnykUaData = new SlovnykUaData($dbh);
$SlovnykUaData->resetProcessing();
$SlovnykUaData->setDownloadingProcessing();

$counter = $SlovnykUaData->countIsNeedProcessing();
$counter = intval($counter/100) + 1;
var_dump($counter);

echo "\n";

//$timeout = 10*60*1000; // 10 min
//ini_set('max_execution_time', 0);
//ini_set('mysql.connect_timeout', $timeout);
//ini_set('default_socket_timeout', $timeout);
//
//// http://www.freeproxylists.net/ru/
//$opts = array(
//    'http'=>array(
//        'method'=>"GET",
//        'proxy' => 'tcp://62.159.193.83:80',
//    )
//);

$context = stream_context_create($opts);

for ($i = 0; $i < $counter;  $i++) {
    echo ($i+1) . ' / ' . $counter. ' ';
    $dataObj = new SlovnykUaData($dbh);
    $allData = $dataObj->getAllIsNeedProcessing(100);

        foreach ($allData as $dataArr) {
            echo '<';

            $id = (int) array_get($dataArr, 'id');

            $data = new SlovnykUaData($dbh);
            $data->getById($id);

            $word_binary = array_get($dataArr, 'word_binary');
            $url = 'http://slovnyk.ua/?swrd=' . urlencode($word_binary);


//            echo $url;
//            echo "\n";
//            echo $word_binary;
//            die;

            $page = file_get_contents($url);
//            $page = file_get_contents($url, false, $context);

//            echo $page;
//            die;

            $htmlData = new SlovnykUaHtml($dbh);
            $htmlData->firstOrNew($id, $word_binary);

            echo ',';

            $htmlData->getByDataId($id); // refresh
//            $htmlData->updateProperty('html', PDO::PARAM_LOB, $page);
//            $htmlData->getByDataId($id); // refresh
            $htmlData->generateCutHtml($page);

            $data->updateProperty('is_has_html', PDO::PARAM_BOOL, true); // we need cut HTML after
            $data->updateProperty('is_need_processing', PDO::PARAM_BOOL, false); // we need cut HTML after

            echo '>';
//            die;
        }

    unset($dataArr);
    unset($dataObj2);
    unset($allData);
    unset($page);
    echo "\n";
}



