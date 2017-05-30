<?php

// @acton: php lcorp_handle_last_name.php

require_once('../support/_require_once.php');

$part_of_language = 'прізвище';

$LcorpDataC = new LcorpData($dbh);

$LcorpDataC->setHtmlRowsToMorphologicalProcessing();

$counter = $LcorpDataC->countPartOfLanguage('%'.$part_of_language.'%', ' LIKE ');
$counter = intval($counter/100) + 1;

echo "\n";
var_dump($counter);

for ($j = 0; $j < $counter;  $j++) {
    $LcorpData = new LcorpData($dbh);
    $allLcorpData = $LcorpData->getPartOfLanguage('%' . $part_of_language . '%', 100, 0, 'LIKE');

    echo "\n$j";

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
        $headers = $xpath->query("//*[contains(@class, 'td_style')]/td");

        $grammatical = $xpath->query("//*[contains(@class, 'gram_style')]");
        $comment = $xpath->query("//*[contains(@class, 'comment_style')]");

        $commentText = null;
        if (0 < $comment->length) {
            $commentText = trim($comment->item(0)->textContent);
        }
        if (0 < $grammatical->length) {
            $commentText .= ' ' . trim($grammatical->item(0)->textContent);
        }

        $header1 = $headers->item(0)->textContent;
        $header2 = $headers->item(1)->textContent;
        $header3 = $headers->item(2)->textContent;

        list($number2, $genus2) = parseHeader($header2);
        list($number3, $genus3) = parseHeader($header3);

        $number4 = null;
        $genus4 = null;

        if (4 === $headers->length) {
            $header4 = $headers->item(3)->textContent;
            list($number4, $genus4) = parseHeader($header4);
        }

        $arr = ['чол. р.', 'жін. р.', 'множина', 'чол. і жін. р.'];

        if ('відмінок' !== trim($header1)) {
            var_dump($dataId);
            var_dump(trim($header1));
            die;
        }

        if (!in_array(trim($header2), $arr)) {
            var_dump($dataId);
            var_dump(trim($header2));
            die;
        }

        if (!in_array(trim($header3), $arr)) {
            var_dump($dataId);
            var_dump(trim($header3));
            die;
        }

        $cell = $xpath->query("//*[contains(@class, 'td_іnner_style')]");

        if (14 === $cell->length || 21 === $cell->length) {
            // OK
        } else {
            var_dump($cell->length);
            die('Wrong amount of cells. Html.id ' . array_get($dataArray, 'id'));
        }

        // main form must be first
        if (3 === $headers->length) {
            $wordForms = [
                [
                    'word' => $cell->item(0)->textContent,
                    'number' => $number2, 'kind' => 'називний',
                    'genus' => $genus2,
                    'isMainForm' => true,
                ],[
                    'word' => $cell->item(1)->textContent,
                    'number' => $number3, 'kind' => 'називний',
                    'genus' => $genus3,
                    'isMainForm' => false,
                ],[
                    'word' => $cell->item(2)->textContent,
                    'number' =>  $number2, 'kind' => 'родовий',
                    'genus' => $genus2,
                    'isMainForm' => false,
                ],[
                    'word' => $cell->item(3)->textContent,
                    'number' =>  $number3, 'kind' => 'родовий',
                    'genus' => $genus3,
                    'isMainForm' => false,
                ],[ // ***
                    'word' => $cell->item(4)->textContent,
                    'number' => $number2, 'kind' => 'давальний',
                    'genus' => $genus2,
                    'isMainForm' => false,
                ],[
                    'word' => $cell->item(5)->textContent,
                    'number' => $number3, 'kind' => 'давальний',
                    'genus' => $genus3,
                    'isMainForm' => false,
                ], [ // ***
                    'word' => $cell->item(6)->textContent,
                    'number' => $number2, 'kind' => 'знахідний',
                    'genus' => $genus2,
                    'isMainForm' => false,
                ],[
                    'word' => $cell->item(7)->textContent,
                    'number' => $number3, 'kind' => 'знахідний',
                    'genus' => $genus3,
                    'isMainForm' => false,
                ],[ // ***
                    'word' => $cell->item(8)->textContent,
                    'number' => $number2, 'kind' => 'орудний',
                    'genus' => $genus2,
                    'isMainForm' => false,
                ],[
                    'word' => $cell->item(9)->textContent,
                    'number' => $number3, 'kind' => 'орудний',
                    'genus' => $genus3,
                    'isMainForm' => false,
                ], [ // ***
                    'word' => Word::cleanWord($cell->item(10)->textContent),
                    'number' => $number2, 'kind' => 'місцевий',
                    'genus' => $genus2,
                    'isMainForm' => false,
                ], [ // ***
                    'word' => Word::cleanWord($cell->item(11)->textContent),
                    'number' => $number3, 'kind' => 'місцевий',
                    'genus' => $genus3,
                    'isMainForm' => false,
                ], [ // ***
                    'word' => $cell->item(12)->textContent,
                    'number' => $number2, 'kind' => 'кличний',
                    'genus' => $genus2,
                    'isMainForm' => false,
                ], [ // ***
                    'word' => $cell->item(13)->textContent,
                    'number' => $number3, 'kind' => 'кличний',
                    'genus' => $genus3,
                    'isMainForm' => false,
                ]
            ];
        } elseif (4 === $headers->length) {
            $wordForms = [
                [
                    'word' => $cell->item(0)->textContent,
                    'number' => $number2, 'kind' => 'називний',
                    'genus' => $genus2,
                    'isMainForm' => true,
                ],[
                    'word' => $cell->item(1)->textContent,
                    'number' => $number3, 'kind' => 'називний',
                    'genus' => $genus3,
                    'isMainForm' => false,
                ],[
                    'word' => $cell->item(2)->textContent,
                    'number' => $number4, 'kind' => 'називний',
                    'genus' => $genus4,
                    'isMainForm' => false,
                ],[
                    'word' => $cell->item(3)->textContent,
                    'number' =>  $number2, 'kind' => 'родовий',
                    'genus' => $genus2,
                    'isMainForm' => false,
                ],[
                    'word' => $cell->item(4)->textContent,
                    'number' =>  $number3, 'kind' => 'родовий',
                    'genus' => $genus3,
                    'isMainForm' => false,
                ],[
                    'word' => $cell->item(5)->textContent,
                    'number' =>  $number4, 'kind' => 'родовий',
                    'genus' => $genus4,
                    'isMainForm' => false,
                ],[ // ***
                    'word' => $cell->item(6)->textContent,
                    'number' => $number2, 'kind' => 'давальний',
                    'genus' => $genus2,
                    'isMainForm' => false,
                ],[
                    'word' => $cell->item(7)->textContent,
                    'number' => $number3, 'kind' => 'давальний',
                    'genus' => $genus3,
                    'isMainForm' => false,
                ],[
                    'word' => $cell->item(8)->textContent,
                    'number' => $number4, 'kind' => 'давальний',
                    'genus' => $genus4,
                    'isMainForm' => false,
                ],[ // ***
                    'word' => $cell->item(9)->textContent,
                    'number' => $number2, 'kind' => 'знахідний',
                    'genus' => $genus2,
                    'isMainForm' => false,
                ],[
                    'word' => $cell->item(10)->textContent,
                    'number' => $number3, 'kind' => 'знахідний',
                    'genus' => $genus3,
                    'isMainForm' => false,
                ],[
                    'word' => $cell->item(11)->textContent,
                    'number' => $number4, 'kind' => 'знахідний',
                    'genus' => $genus4,
                    'isMainForm' => false,
                ],[ // ***
                    'word' => $cell->item(12)->textContent,
                    'number' => $number2, 'kind' => 'орудний',
                    'genus' => $genus2,
                    'isMainForm' => false,
                ],[
                    'word' => $cell->item(13)->textContent,
                    'number' => $number3, 'kind' => 'орудний',
                    'genus' => $genus3,
                    'isMainForm' => false,
                ],[
                    'word' => $cell->item(14)->textContent,
                    'number' => $number4, 'kind' => 'орудний',
                    'genus' => $genus4,
                    'isMainForm' => false,
                ],[ // ***
                    'word' => Word::cleanWord($cell->item(15)->textContent),
                    'number' => $number2, 'kind' => 'місцевий',
                    'genus' => $genus2,
                    'isMainForm' => false,
                ],[ // ***
                    'word' => Word::cleanWord($cell->item(16)->textContent),
                    'number' => $number3, 'kind' => 'місцевий',
                    'genus' => $genus3,
                    'isMainForm' => false,
                ],[ // ***
                    'word' => Word::cleanWord($cell->item(17)->textContent),
                    'number' => $number4, 'kind' => 'місцевий',
                    'genus' => $genus4,
                    'isMainForm' => false,
                ],[ // ***
                    'word' => $cell->item(18)->textContent,
                    'number' => $number2, 'kind' => 'кличний',
                    'genus' => $genus2,
                    'isMainForm' => false,
                ],[ // ***
                    'word' => $cell->item(19)->textContent,
                    'number' => $number3, 'kind' => 'кличний',
                    'genus' => $genus3,
                    'isMainForm' => false,
                ],[ // ***
                    'word' => $cell->item(20)->textContent,
                    'number' => $number4, 'kind' => 'кличний',
                    'genus' => $genus4,
                    'isMainForm' => false,
                ]
            ];
        }

        $mainFormId = null;

        foreach ($wordForms as $wordForm) {
            echo '+';
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


// 'чол. р.', 'жін. р.', 'множина', 'чол. і жін. р.'
function parseHeader($header)
{
    if (-1 < mb_strpos($header, 'множина')) {
        return ['-', 'множина'];
    } elseif (-1 < mb_strpos($header, 'чол. і жін. р.')) {
        return ['чоловічий,жіночий', 'однина'];
    } elseif (-1 < mb_strpos($header, 'чол. р.')) {
        return ['чоловічий', 'однина'];
    } elseif (-1 < mb_strpos($header, 'жін. р.')) {
        return ['жіночий', 'однина'];
    }

    return ['-', '-'];
}




