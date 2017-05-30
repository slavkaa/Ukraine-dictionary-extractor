<?php

// @acton: php lcorp_handle_adverb.php

require_once('../support/_require_once.php');

$part_of_language = '- прислівник';
$part_of_language_sql = $part_of_language . '%';

$LcorpDataC = new LcorpData($dbh);
$LcorpDataC->setHtmlRowsToMorphologicalProcessing();

$counter = $LcorpDataC->countPartOfLanguage($part_of_language_sql, 'LIKE');
$counter = intval($counter/100) + 1;

echo "\n";
var_dump($counter);

for ($j = 0; $j < $counter + 1;  $j++) {
    $LcorpData = new LcorpData($dbh);
    $allLcorpData = $LcorpData->getPartOfLanguage($part_of_language_sql, 100, 0, 'LIKE');

    echo "\n$j / $counter ";

    foreach ($allLcorpData as $dataArray) {
        echo "<";
        $dataId = array_get($dataArray, 'id');

        $data = new LcorpData($dbh);
        $data->getById($dataId);

        $html = new LcorpHtml($dbh);
        $html->getByDataId($dataId);

        // load extracted HTML=page
        $text = cleanCyrillic($html->getProperty('html_cut'));
        $text = str_replace("\n", '', $text);
        $url = $html->getProperty('url');

        // filtrate noun {
        // init HTML parser
        $doc = new DOMDocument();
        $doc->encoding = 'UTF-8';
        @$doc->loadHTML(mb_convert_encoding($text, 'HTML-ENTITIES', 'UTF-8'));


        // extract table
        $xpath = new DOMXpath($doc);
        /** @var DOMNodeList $partOfLanguageData */
        $headers = $xpath->query("//*[contains(@class, 'td_style')]");
        $cell = $xpath->query("//*[contains(@class, 'td_іnner_style')]");

        $wordLcorp = $xpath->query("//*[contains(@class, 'word_style')]");
        $wordLcorp = $wordLcorp->item(0)->textContent;
        $grammatical = $xpath->query("//*[contains(@class, 'gram_style')]");
        $comment = $xpath->query("//*[contains(@class, 'comment_style')]");

        $commentText = null;
        if (0 < $comment->length) {
            $commentText = trim($comment->item(0)->textContent);
        }
        if (0 < $grammatical->length) {
            $commentText .= ' ' . trim($grammatical->item(0)->textContent);
        }

// ********************************************************************************************************************
//        if (3 !== $headers->length) {
//            var_dump($dataId);
//            var_dump($text);
//            die;
//        } else {
//            $data->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
//            continue;
//        }

//        if (0 !== $comment->length) {
//            $t = trim($comment->item(0)->textContent);
//            if (!empty($t)) {
//                var_dump($comment->item(0)->textContent);
//                var_dump($dataId);
//                var_dump($text);
//                die;
//            }
//        }
//
//        $data->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
//        continue;
// ********************************************************************************************************************

//        $h1 = trim($headers->item(1)->textContent);
//        $h2 = trim($headers->item(2)->textContent);
//
//        if ('однина' != $h1 || 'множина' != $h2) {
//            var_dump($h1, $h2, $dataId);
//            die;
//        }

//        elseif (28 === $cell->length) {
//            $h1 = trim($headers->item(3)->textContent);
//            $h2 = trim($headers->item(4)->textContent);
//            $h3 = trim($headers->item(5)->textContent);
//            $h4 = trim($headers->item(2)->textContent);
//            if ('чол. р.' != $h1 || 'жін. р.' != $h2 || 'сер. р.' != $h3 || 'множина' != $h4) {
//                var_dump($h1, $h2, $dataId);
//                die('#2');
//            }
//        }

//        if (0 === $cell->length) {
//            // OK
//        }  else {
//            var_dump($cell->length);
//            die('Wrong amount of cells. Html.id ' . array_get($dataArray, 'id'));
//        }
//
//        $data->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
//        continue;

        $word = str_replace($part_of_language, '', $wordLcorp);

        if (' ' == $word || empty($word)) {
            continue;
        }

        if (0 < strpos($word, ',')) {
            $wordVariantsArr = explode(',', $word);
            foreach ($wordVariantsArr as $word) {
                $word = trim($word);

                $result = new LcorpResults($dbh);
                $result->firstOrNewTotal($word, $part_of_language, '-', '-', '-', '-', '-', '-',
                    '-', '-', '-', '-', '-', '-', false, 1, '-', $dataId);

                $result->updateProperty('main_form_code', PDO::PARAM_STR, $mainFormId);
                $result->updateProperty('data_id', PDO::PARAM_INT, $dataId);
                $result->updateProperty('description', PDO::PARAM_STR, $commentText);
            }
        } else {
            $result = new LcorpResults($dbh);
            $result->firstOrNewTotal($word, $part_of_language, '-', '-', '-', '-', '-', '-',
                '-', '-', '-', '-', '-', '-', false, 1, '-', $dataId);

            $result->updateProperty('main_form_code', PDO::PARAM_STR, $mainFormId);
            $result->updateProperty('data_id', PDO::PARAM_INT, $dataId);
            $result->updateProperty('description', PDO::PARAM_STR, $commentText);
        }

        $data->updateProperty('is_in_results', PDO::PARAM_BOOL, true);

        $data->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);

        echo ">";
//        die;
    }

//    echo "\n";
}

$LcorpDataC->setHtmlRowsToMorphologicalProcessing();

echo 'END';