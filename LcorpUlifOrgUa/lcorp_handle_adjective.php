<?php

// @acton: php lcorp_handle_adjective.php

require_once('../support/_require_once.php');

$part_of_language = 'прикметник';
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

//        if (24 === $cell->length) {
//            $h4 = trim($headers->item(2)->textContent);
//            if ('множина' != $h4) {
//                var_dump($h4, $dataId);
//                var_dump(
//                    $headers->item(0)->textContent,
//                    $headers->item(1)->textContent,
//                    $headers->item(2)->textContent,
//                    $headers->item(3)->textContent
//                );
//                die('#2');
//            }
//        }
//
//        $data->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
//        continue;

        $wordForms = [];

        // main form must be first
        if (24 === $cell->length) {
            $wordForms = [
                [
                    'word' => $cell->item(0)->textContent,
                    'number' => 'однина', 'kind' => 'називний',
                    'genus' => 'чоловічий',
                    'isMainForm' => true,
                ],[
                    'word' => $cell->item(1)->textContent,
                    'number' => 'однина', 'kind' => 'називний',
                    'genus' => 'жіночий',
                    'isMainForm' => false,
                ],[
                    'word' => $cell->item(2)->textContent,
                    'number' => 'однина', 'kind' => 'називний',
                    'genus' => 'середний',
                    'isMainForm' => false,
                ],[
                    'word' => $cell->item(2)->textContent,
                    'number' => 'множина', 'kind' => 'називний',
                    'genus' => '-',
                    'isMainForm' => false,
                ],[
                    'word' => $cell->item(3)->textContent,
                    'number' =>  'однина', 'kind' => 'родовий',
                    'genus' => 'чоловічий',
                    'isMainForm' => false,
                ],[
                    'word' => $cell->item(4)->textContent,
                    'number' =>  'однина', 'kind' => 'родовий',
                    'genus' => 'жіночий',
                    'isMainForm' => false,
                ],[
                    'word' => $cell->item(5)->textContent,
                    'number' =>  'однина', 'kind' => 'родовий',
                    'genus' => 'середний',
                    'isMainForm' => false,
                ],[
                    'word' => $cell->item(5)->textContent,
                    'number' =>  'множина', 'kind' => 'родовий',
                    'genus' => '-',
                    'isMainForm' => false,
                ],[
                    'word' => $cell->item(6)->textContent,
                    'number' => 'однина', 'kind' => 'давальний',
                    'genus' => 'чоловічий',
                    'isMainForm' => false,
                ],[
                    'word' => $cell->item(7)->textContent,
                    'number' => 'однина', 'kind' => 'давальний',
                    'genus' => 'жіночий',
                    'isMainForm' => false,
                ],[
                    'word' => $cell->item(8)->textContent,
                    'number' => 'однина', 'kind' => 'давальний',
                    'genus' => 'середний',
                    'isMainForm' => false,
                ],[
                    'word' => $cell->item(8)->textContent,
                    'number' => 'множина', 'kind' => 'давальний',
                    'genus' => '-',
                    'isMainForm' => false,
                ],[
                    'word' => $cell->item(9)->textContent,
                    'number' => 'однина', 'kind' => 'знахідний',
                    'genus' => 'чоловічий',
                    'isMainForm' => false,
                ],[
                    'word' => $cell->item(10)->textContent,
                    'number' => 'однина', 'kind' => 'знахідний',
                    'genus' => 'жіночий',
                    'isMainForm' => false,
                ],[
                    'word' => $cell->item(11)->textContent,
                    'number' => 'однина', 'kind' => 'знахідний',
                    'genus' => 'середний',
                    'isMainForm' => false,
                ],[
                    'word' => $cell->item(11)->textContent,
                    'number' => 'множина', 'kind' => 'знахідний',
                    'genus' => '-',
                    'isMainForm' => false,
                ],[
                    'word' => $cell->item(12)->textContent,
                    'number' => 'однина', 'kind' => 'орудний',
                    'genus' => 'чоловічий',
                    'isMainForm' => false,
                ],[
                    'word' => $cell->item(13)->textContent,
                    'number' => 'однина', 'kind' => 'орудний',
                    'genus' => 'жіночий',
                    'isMainForm' => false,
                ],[
                    'word' => $cell->item(14)->textContent,
                    'number' => 'однина', 'kind' => 'орудний',
                    'genus' => 'середний',
                    'isMainForm' => false,
                ],[
                    'word' => $cell->item(14)->textContent,
                    'number' => 'множина', 'kind' => 'орудний',
                    'genus' => '-',
                    'isMainForm' => false,
                ],[
                    'word' => Word::cleanWord($cell->item(15)->textContent),
                    'number' => 'однина', 'kind' => 'місцевий',
                    'genus' => 'чоловічий',
                    'isMainForm' => false,
                ],[
                    'word' => Word::cleanWord($cell->item(16)->textContent),
                    'number' => 'однина', 'kind' => 'місцевий',
                    'genus' => 'жіночий',
                    'isMainForm' => false,
                ],[
                    'word' => Word::cleanWord($cell->item(17)->textContent),
                    'number' => 'однина', 'kind' => 'місцевий',
                    'genus' => 'середний',
                    'isMainForm' => false,
                ],[
                    'word' => Word::cleanWord($cell->item(17)->textContent),
                    'number' => 'множина', 'kind' => 'місцевий',
                    'genus' => '-',
                    'isMainForm' => false,
                ]
            ];
        }

        $mainFormId = null;

        foreach ($wordForms as $wordForm) {
            $word = trim(array_get($wordForm, 'word'));

            if (' ' == $word || empty($word)) {
                continue;
            }

            $number = array_get($wordForm, 'number', '-');
            $kind = array_get($wordForm, 'kind', '-');
            $genus = array_get($wordForm, 'genus', '-');
            $is_main_form = array_get($wordForm, 'isMainForm', false);

            $number = $number ? $number : '-';
            $kind = $kind ? $kind: '-';
            $genus = $genus ? $genus: '-';

            if (0 < strpos($word, ',')) {
                $wordVariantsArr = explode(',', $word);
                foreach ($wordVariantsArr as $word) {
                    $word = trim($word);

                    $result = new LcorpResults($dbh);
                    $result->firstOrNewTotal($word, $part_of_language, 'істота', $genus, $number, '-', $kind, '-',
                        '-', '-', '-', '-', '-', '-', false, $is_main_form, '-', $dataId);

                    if ($is_main_form) {
                        $mainFormId = $result->getId();
                    }

                    $result->updateProperty('main_form_code', PDO::PARAM_STR, $mainFormId);
                    $result->updateProperty('data_id', PDO::PARAM_INT, $dataId);
                    $result->updateProperty('description', PDO::PARAM_STR, $commentText);
                }
            } else {
                $result = new LcorpResults($dbh);
                $result->firstOrNewTotal($word, $part_of_language, 'істота', $genus, $number, '-', $kind, '-',
                    '-', '-', '-', '-', '-', '-', false, $is_main_form, '-', $dataId);

                if ($is_main_form) {
                    $mainFormId = $result->getId();
                }

                $result->updateProperty('main_form_code', PDO::PARAM_STR, $mainFormId);
                $result->updateProperty('data_id', PDO::PARAM_INT, $dataId);
                $result->updateProperty('description', PDO::PARAM_STR, $commentText);
            }

            $data->updateProperty('is_in_results', PDO::PARAM_BOOL, true);
        }

        $data->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);

        echo ">";
//        die;
    }

    echo "\n";
}

$LcorpDataC->setHtmlRowsToMorphologicalProcessing();

echo 'END';