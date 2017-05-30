<?php

// @acton: php lcorp_handle_verb.php

require_once('../support/_require_once.php');

$part_of_language = 'дієслово';
$part_of_language_sql = '%' . $part_of_language . '%';

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
        $cellCenter = $xpath->query("//*[contains(@class, 'td_іnner_center_style')]");

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

//        $colspans = mb_substr_count($text, 'colspan');
//
//        if (20 === $cell->length) {
//            $genusMale = mb_substr_count($text, 'чол. р.');
//            $genusFemale = mb_substr_count($text, 'жін. р.');
//            $genusMiddle = mb_substr_count($text, 'сер. р.');
//            $osoba1 = mb_substr_count($text, '1 особа');
//            $osoba2 = mb_substr_count($text, '2 особа');
//            $osoba3 = mb_substr_count($text, '3 особа');
//
//            if (1 != $genusMale || 1 != $genusFemale || 1 != $genusMiddle || 3 != $osoba1 || 3 != $osoba2 || 2 != $osoba3) {
//                var_dump($dataId);
//                die('#1');
//            }
//
//            if (17 != $colspans) {
//                var_dump($colspans, $dataId);
//                die('#3');
//            }
//
//            $c1 = trim($cellCenter->item(1)->textContent);
//            $c3 = trim($cellCenter->item(3)->textContent);
//            $c4 = trim($cellCenter->item(4)->textContent);
//            $c5 = trim($cellCenter->item(5)->textContent);
//
//            if (!empty($c1) || !empty($c3) || !empty($c4) || !empty($c5)) {
//                var_dump($dataId);
//                var_dump($c1, $c3, $c4, $c5);
//                die ('#4');
//            }
//
//        } elseif (14 === $cell->length) {
//            $text = str_replace(['чол. р.', 'жін. р.', 'сер. р.'],['чол.р.', 'жін.р.', 'сер.р.'], $text);
//            $genusMale = mb_substr_count($text, 'чол.р.');
//            $genusFemale = mb_substr_count($text, 'жін.р.');
//            $genusMiddle = mb_substr_count($text, 'сер.р.');
//            $osoba1 = mb_substr_count($text, '1 особа');
//            $osoba2 = mb_substr_count($text, '2 особа');
//            $osoba3 = mb_substr_count($text, '3 особа');
//            $tenceNow = mb_substr_count($text, 'ТЕПЕРІШНІЙ ЧАС ');
//
//            if (1 != $genusMale || 1 != $genusFemale || 1 != $genusMiddle || 2 != $osoba1 || 2 != $osoba2 || 1 != $osoba3 || 0 != $tenceNow) {
//                var_dump($dataId);
//                var_dump($genusMale, $genusFemale, $genusMiddle, $osoba1, $osoba2, $osoba3, $tenceNow);
//                die('#2');
//            }
//
//            if (12 != $colspans) {
//                var_dump($colspans, $dataId);
//                die('#3');
//            }
//
//            $c1 = trim($cellCenter->item(1)->textContent);
//            $c2 = trim($cellCenter->item(2)->textContent);
//            $c3 = trim($cellCenter->item(3)->textContent);
//
//            if (!empty($c1) || !empty($c2) || !empty($c3)) {
//                var_dump($dataId);
//                var_dump($c1, $c2, $c3);
//                die ('#5');
//            }
//
//        } else {
//            var_dump($cell->length);
//            die('Wrong amount of cells. Html.id ' . array_get($dataArray, 'id'));
//        }
//
//        $data->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
//        continue;

        $infinitive = trim($cellCenter->item(0)->textContent);

//        echo $text;
//        var_dump($dataId);
//        var_dump($cell->length);
//        var_dump(mb_substr_count($text, 'td_іnner_center_style'));
//        var_dump($cellCenter->length);
//        var_dump($infinitive);
//        die;

        $wordForms = [];

        // main form must be first
        if (20 === $cell->length) {
            $wordForms = [
                [ // ***
                    'word' => trim($cell->item(0)->textContent),
                    'tense' => 'наказовий спосіб',
                    'number' => 'однина',
                    'person' => '1 особа',
                ],[
                    'word' => $cell->item(1)->textContent,
                    'tense' => 'наказовий спосіб',
                    'number' => 'множина',
                    'person' => '1 особа',
                ],[
                    'word' => $cell->item(2)->textContent,
                    'tense' => 'наказовий спосіб',
                    'number' => 'однина',
                    'person' => '2 особа',
                ],[
                    'word' => $cell->item(3)->textContent,
                    'tense' => 'наказовий спосіб',
                    'number' => 'множина',
                    'person' => '2 особа',
                ],[ // ***
                    'word' => $cell->item(4)->textContent,
                    'tense' => 'майбутній',
                    'number' => 'однина',
                    'person' => '1 особа',
                ],[
                    'word' => $cell->item(5)->textContent,
                    'tense' => 'майбутній',
                    'number' => 'множина',
                    'person' => '1 особа',
                ],[
                    'word' => $cell->item(6)->textContent,
                    'tense' => 'майбутній',
                    'number' => 'однина',
                    'person' => '2 особа',
                ],[
                    'word' => $cell->item(7)->textContent,
                    'tense' => 'майбутній',
                    'number' => 'множина',
                    'person' => '2 особа',
                ],[
                    'word' => $cell->item(8)->textContent,
                    'tense' => 'майбутній',
                    'number' => 'однина',
                    'person' => '3 особа',
                ],[
                    'word' => $cell->item(9)->textContent,
                    'tense' => 'майбутній',
                    'number' => 'множина',
                    'person' => '3 особа',
                ],[ // ***
                    'word' => $cell->item(10)->textContent,
                    'tense' => 'теперішній',
                    'number' => 'однина',
                    'person' => '1 особа',
                ],[
                    'word' => $cell->item(11)->textContent,
                    'tense' => 'теперішній',
                    'number' => 'множина',
                    'person' => '1 особа',
                ],[
                    'word' => $cell->item(12)->textContent,
                    'tense' => 'теперішній',
                    'number' => 'однина',
                    'person' => '2 особа',
                ],[
                    'word' => $cell->item(13)->textContent,
                    'tense' => 'теперішній',
                    'number' => 'множина',
                    'person' => '2 особа',
                ],[
                    'word' => $cell->item(14)->textContent,
                    'tense' => 'теперішній',
                    'number' => 'однина',
                    'person' => '3 особа',
                ],[
                    'word' => $cell->item(15)->textContent,
                    'tense' => 'теперішній',
                    'number' => 'множина',
                    'person' => '3 особа',
                ],[ // ***
                    // !!!
                    'word' => $cell->item(16)->textContent,
                    'tense' => 'минулий',
                    'number' => 'однина',
                    'genus' => 'чоловічий',
                ],[
                    'word' => $cell->item(17)->textContent,
                    'tense' => 'минулий',
                    'number' => 'множина',
                    'person' => '1 особа',
                ],[
                    'word' => $cell->item(17)->textContent,
                    'tense' => 'минулий',
                    'number' => 'множина',
                    'person' => '2 особа',
                ],[
                    'word' => $cell->item(17)->textContent,
                    'tense' => 'минулий',
                    'number' => 'множина',
                    'person' => '3 особа',
                ],[
                    'word' => $cell->item(18)->textContent,
                    'tense' => 'минулий',
                    'number' => 'однина',
                    'genus' => 'жіночий',
                ],[
                    'word' => $cell->item(19)->textContent,
                    'tense' => 'минулий',
                    'number' => 'однина',
                    'genus' => 'середній',
                ]
            ];

            $diepruslivnyk = [
                [
                    'word' => trim($cellCenter->item(2)->textContent),
                    'tense' => 'теперішній',
                ],[
                    'word' => trim($cellCenter->item(6)->textContent),
                    'tense' => 'минулий',
                ]
            ];
        } elseif (14 === $cell->length) {
            $wordForms = [
                [ // ***
                    'word' => trim($cell->item(0)->textContent),
                    'tense' => 'наказовий спосіб',
                    'number' => 'однина',
                    'person' => '1 особа',
                ],[
                    'word' => $cell->item(1)->textContent,
                    'tense' => 'наказовий спосіб',
                    'number' => 'множина',
                    'person' => '1 особа',
                ],[
                    'word' => $cell->item(2)->textContent,
                    'tense' => 'наказовий спосіб',
                    'number' => 'однина',
                    'person' => '2 особа',
                ],[
                    'word' => $cell->item(3)->textContent,
                    'tense' => 'наказовий спосіб',
                    'number' => 'множина',
                    'person' => '2 особа',
                ],[ // ***
                    'word' => $cell->item(4)->textContent,
                    'tense' => 'майбутній',
                    'number' => 'однина',
                    'person' => '1 особа',
                ],[
                    'word' => $cell->item(5)->textContent,
                    'tense' => 'майбутній',
                    'number' => 'множина',
                    'person' => '1 особа',
                ],[
                    'word' => $cell->item(6)->textContent,
                    'tense' => 'майбутній',
                    'number' => 'однина',
                    'person' => '2 особа',
                ],[
                    'word' => $cell->item(7)->textContent,
                    'tense' => 'майбутній',
                    'number' => 'множина',
                    'person' => '2 особа',
                ],[
                    'word' => $cell->item(8)->textContent,
                    'tense' => 'майбутній',
                    'number' => 'однина',
                    'person' => '3 особа',
                ],[
                    'word' => $cell->item(9)->textContent,
                    'tense' => 'майбутній',
                    'number' => 'множина',
                    'person' => '3 особа',
                ],[ // ***
                    // !!!
                    'word' => $cell->item(10)->textContent,
                    'tense' => 'минулий',
                    'number' => 'однина',
                    'genus' => 'чоловічий',
                ],[
                    'word' => $cell->item(11)->textContent,
                    'tense' => 'минулий',
                    'number' => 'множина',
                    'person' => '1 особа',
                ],[
                    'word' => $cell->item(11)->textContent,
                    'tense' => 'минулий',
                    'number' => 'множина',
                    'person' => '2 особа',
                ],[
                    'word' => $cell->item(11)->textContent,
                    'tense' => 'минулий',
                    'number' => 'множина',
                    'person' => '3 особа',
                ],[
                    'word' => $cell->item(12)->textContent,
                    'tense' => 'минулий',
                    'number' => 'однина',
                    'genus' => 'жіночий',
                ],[
                    'word' => $cell->item(14)->textContent,
                    'tense' => 'минулий',
                    'number' => 'однина',
                    'genus' => 'середній',
                ]
            ];

            $diepruslivnyk = [
                [
                    'word' => trim($cellCenter->item(4)->textContent),
                    'tense' => 'минулий',
                ]
            ];
        }

        $mainFormId = null;

        // define infinitive {
        $mainFormId = null;
        if ( " " != $infinitive && !empty($infinitive)) {

            if (0 < strpos($infinitive, ',')) {
                $wordVariantsArr = explode(',', $infinitive);

                foreach ($wordVariantsArr as $word) {
                    $word = trim($word);

                    echo 'i';
                    $result = new LcorpResults($dbh);
                    $result->firstOrNewTotal($word, 'дієслово', '-', '-', '-', '-', '-', '-',
                        '-', '-', '-', '-', '-', '-', 1, 1, '-');
                    if (null === $mainFormId) {
                        $mainFormId = $result->getId();
                    }

                    $result->updateProperty('main_form_code', PDO::PARAM_STR, $mainFormCodePrefix . $mainFormId);
                    $result->updateProperty('data_id', PDO::PARAM_INT, $dataId);
                    $result->updateProperty('description', PDO::PARAM_STR, $commentText);

                    $isHasCommas = true;
                }
            } else {
                echo 'i';
                $result = new LcorpResults($dbh);
                $result->firstOrNewTotal($word, 'дієслово', '-', '-', '-', '-', '-', '-',
                    '-', '-', '-', '-', '-', '-', 1, 1, '-');
                $mainFormId = $result->getId();

                $result->updateProperty('main_form_code', PDO::PARAM_STR, $mainFormCodePrefix . $mainFormId);
                $result->updateProperty('data_id', PDO::PARAM_INT, $dataId);
                $result->updateProperty('description', PDO::PARAM_STR, $commentText);
            }

            $data->updateProperty('is_in_results', PDO::PARAM_BOOL, true);
        }
        // define infinitive }

        foreach ($wordForms as $wordForm) {
            $word = trim(array_get($wordForm, 'word'));

            if (' ' == $word || ' ' == $word || empty($word)) {
                continue;
            }

            $tense = str_replace('', '', array_get($wordForm, 'tense', '-'));
            $number = array_get($wordForm, 'number', '-');
            $genus = array_get($wordForm, 'genus', '-');
            $person = array_get($wordForm, 'person', '-');

            $genus = $genus ? $genus : '-';
            $tense = $tense ? $tense : '-';
            $number = $number ? $number : '-';
            $person = $person ? $person : '-';

            if (0 < strpos($word, ',')) {
                $wordVariantsArr = explode(',', $word);
                foreach ($wordVariantsArr as $word) {
                    $word = trim($word);

                    echo 'd';
                    $result = new LcorpResults($dbh);
                    $result->firstOrNewTotal($word, $part_of_language, '-', $genus, $number, $person, '-', '-',
                        '-', '-', '-', '-', $tense, '-', false, false, '-');

                    $result->updateProperty('main_form_code', PDO::PARAM_STR, $mainFormId);
                    $result->updateProperty('data_id', PDO::PARAM_INT, $dataId);
                    $result->updateProperty('description', PDO::PARAM_STR, $commentText);
                }
            } else {

                echo 'd';
                $result = new LcorpResults($dbh);
                $result->firstOrNewTotal($word, $part_of_language, '-', $genus, $number, $person, '-', '-',
                    '-', '-', '-', '-', $tense, '-', false, false, '-');

                $result->updateProperty('main_form_code', PDO::PARAM_STR, $mainFormId);
                $result->updateProperty('data_id', PDO::PARAM_INT, $dataId);
                $result->updateProperty('description', PDO::PARAM_STR, $commentText);
            }

            $data->updateProperty('is_in_results', PDO::PARAM_BOOL, true);
        }

        foreach ($diepruslivnyk as $wordForm) {
            $word = trim(array_get($wordForm, 'word'));
            $tense = array_get($wordForm, 'tense', '-');

            if (" " == $word ||' ' == $word || empty($word)) {
                continue;
            }

            if (0 < strpos($word, ',')) {
                $wordVariantsArr = explode(',', $word);
                foreach ($wordVariantsArr as $word) {
                    $word = trim($word);
                    echo 'p';

                    $result = new LcorpResults($dbh);
                    $result->firstOrNewTotal(trim($word), 'дієприслівник', '-', '-', '-', '-', '-', '-',
                        '-', '-', '-', '-', $tense, '-', 0, 0, '-');
                    $result->updateProperty('main_form_code', PDO::PARAM_STR, $mainFormCodePrefix . $mainFormId);
                    $result->updateProperty('data_id', PDO::PARAM_INT, $dataId);

                    $isHasCommas = true;
                }
            } else {
                echo 'p';
                $result = new LcorpResults($dbh);
                $result->firstOrNewTotal(trim($word), 'дієприслівник', '-', '-', '-', '-', '-', '-',
                    '-', '-', '-', '-', $tense, '-', 0, 0, '-');
                $result->updateProperty('main_form_code', PDO::PARAM_STR, $mainFormCodePrefix . $mainFormId);
                $result->updateProperty('data_id', PDO::PARAM_INT, $dataId);
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