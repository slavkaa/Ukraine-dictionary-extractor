<?php

// @acton: php download_html.php

require_once('../support/_require_once.php');

// *** //

$Obj = new SumInUaData($dbh);
$counter = $Obj->countIsNeedProcessing();
$counter = intval($counter/100) + 1;
var_dump($counter);

echo "\n";

for ($i = 1; $i < $counter;  $i++) {
    echo $i . '00.';
    $Data = new SumInUaData($dbh);
    $allData = $Data->getAllIsNeedProcessing(100);

        foreach ($allData as $DataArr) {
            echo '<';

            $id = (int) array_get($DataArr, 'id');
            $word = array_get($DataArr, 'word_binary');
            
            $Data2 = new SumInUaData($dbh);
            $Data2->getById($id);

            // request {
            // @link: http://stackoverflow.com/questions/2445276/how-to-post-data-in-php-using-file-get-contents

            $postData = http_build_query(['query' => $word]);

            $opts = [
                'http' => [
                    'method'  => 'POST',
                    'header'  => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $postData
                ]
            ];

            $context  = stream_context_create($opts);

            $page = file_get_contents('http://sum.in.ua/search', false, $context);

            // request }

            $Html = new SumInUaHtml($dbh);
            $Html->firstOrNew($id, $word);

            $Html->updateProperty('html', PDO::PARAM_LOB, $page);
            $Html->getByDataId($id); // refresh

            $Html->generateCutHtml();

            $Data2->updateProperty('is_need_processing', PDO::PARAM_BOOL, false); // we need cut HTML after

            echo '>';
        }

    unset($DataArr);
    unset($Data2);
    unset($allHtml);
    unset($page);
    echo "\n";
}



