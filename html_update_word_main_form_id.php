<?php

// @link: http://phpfaq.ru/pdo
// @acton: php html_update_word_main_form_id.php

require_once('support/config.php');
require_once('support/functions.php');
require_once('support/libs.php');
require_once('models/word.php');
require_once('models/wordToIgnore.php');
require_once('models/source.php');
require_once('models/dictionary.php');
require_once('models/html.php');

// *** //

echo "*** PROCESSING 1 \n";

//$lib = [];
//
//for ($i = 1; $i < 4630;  $i++) {
//    $htmlObj = new Html($dbh);
//    $allHtml = $htmlObj->getAllIsNeedProcessing(100);
//
//    echo $i . '00. ';
//
//    foreach ($allHtml as $htmlArr) {
//        $id = array_get($htmlArr, 'id');
//        $word_id = array_get($htmlArr, 'word_id');
//        $is_main_form = array_get($htmlArr, 'is_main_form', false);
//
//        if ($is_main_form && !empty($word_id)) {
//            $lib[$id] = $word_id;
//            echo 'M';
//        }
//
//        $html = new Html($dbh);
//        $html->getById($id);
//        $html->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
//    }
//    echo "\n";
//}
//
//echo "*** UPDATE \n";

//$stm = $dbh->prepare('UPDATE html SET is_need_processing = 1 where is_need_processing = 0;');
//$stm->execute();

$lib = unserialize(file_get_contents('array.txt'));
//file_put_contents('array.txt', serialize($lib));

//var_dump($lib);
//echo implode(',', array_keys($lib));
//die;

echo "*** PROCESSING 2 \n";

for ($i = 1; $i < 1830;  $i++) {
    $htmlObj = new Html($dbh);
    $allHtml = $htmlObj->getAllIsNeedProcessing(100);

    echo $i . '00. ';

    foreach ($allHtml as $htmlArr) {
        $id = array_get($htmlArr, 'id');
        $word_id = array_get($htmlArr, 'word_id');
        $is_main_form = array_get($htmlArr, 'is_main_form', false);
        $main_form_id = array_get($htmlArr, 'main_form_id');
        $url = array_get($htmlArr, 'url');

        $html = new Html($dbh);
        $html->getById($id);

        if (null != $main_form_id) {
            if (empty($word_id)) {
                echo 'E';
                $html->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
                continue;
            }

            $word_main_form_id = array_get($lib, $main_form_id);
            echo sprintf('(%s-%s)', $main_form_id, $word_main_form_id);

            if ($word_main_form_id) {
                echo '+';

                $word = new Word($dbh);
                $word->getById($word_id);
                $word->updateProperty('main_form_id', PDO::PARAM_INT, $word_main_form_id);
            } else {
                echo '-';
            }
        }

        $html->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
    }
    echo "\n";
}




