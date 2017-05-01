<?php

// @acton: php slovnyk_ua_handle_pronoun.php    Займенник

require_once('../support/_require_once.php');

$part_of_language = 'займенник';

$SlovnykUaDataC = new SlovnykUaData($dbh);
$counter = $SlovnykUaDataC->countPartOfLanguage('%'.$part_of_language.'%', ' LIKE ');
$counter = intval($counter/100) + 1;

echo "\n";
var_dump($counter);

for ($j = 0; $j < $counter;  $j++) {
    $SlovnykUaData = new SlovnykUaData($dbh);
    $allSlovnykUaData = $SlovnykUaData->getPartOfLanguage('%' . $part_of_language . '%', 100, 0, 'LIKE');

    echo "\n$j";

    foreach ($allSlovnykUaData as $dataArray) {
        echo "<";
        $dataId = array_get($dataArray, 'id');

        $data = new SlovnykUaData($dbh);
        $data->getById($dataId);

        $html = new SlovnykUaHtml($dbh);
        $html->getByDataId($dataId);

        // load extracted HTML=page
        $word = cleanCyrillic($html->getProperty('word'));

        $text = cleanCyrillic($html->getProperty('html_cut'));
        $text = str_replace(
            ['sfm_cell_1s', 'sfm_cell_2s', 'sfm_cell_1_x2', 'sfm_cell_1e_x2', 'sfm_cell_1e', 'sfm_cell_2_x2', 'sfm_cell_2e_x2', 'sfm_cell_2e'],
            ['sfm_cell_v',  'sfm_cell_v',  'sfm_cell_1',    'sfm_cell_e_1',   'sfm_cell_e_1',   'sfm_cell_2',    'sfm_cell_2e', 'sfm_cell_e_2'],
            $text);

        // filtrate noun {
        // init HTML parser
        $doc = new DOMDocument();
        $doc->encoding = 'UTF-8';
        @$doc->loadHTML(mb_convert_encoding($text, 'HTML-ENTITIES', 'UTF-8'));

        // extract tables
        $xpath = new DOMXpath($doc);
        $tables = $xpath->query("//*[contains(@class, 'sfm_table')]");

        $isFound = false;
        for ($i = 0; $i < $tables->length; $i++) {
            $item = $tables->item($i);
            if (-1 < strpos($item->textContent, $part_of_language)) {
                $doc = new DOMDocument();
                @$doc->loadHTML(mb_convert_encoding($item->ownerDocument->saveHTML($item), 'HTML-ENTITIES', 'UTF-8'));
                $isFound = true;

                $data->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
                break;
            }
        }

        if (!$isFound) {
            $data->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
            continue;
        }
        // filtrate noun }

        // extract table
        $xpath = new DOMXpath($doc);
        /** @var DOMNodeList $partOfLanguageData */
        $definition = $xpath->query("//*[contains(@class, 'sfm_cell_hx')]");
        $definition = $definition->item(0)->textContent;
        $definition = explode('(', $definition);

        $class = str_replace([')', ' '], '', array_get($definition, 1));

        $cell1 = $xpath->query("//*[contains(@class, 'sfm_cell_1')]");
        $cell1e = $xpath->query("//*[contains(@class, 'sfm_cell_e_1')]");
        $cell2 = $xpath->query("//*[contains(@class, 'sfm_cell_2')]");
        $cell2e = $xpath->query("//*[contains(@class, 'sfm_cell_e_2')]");

        if (9 === $cell1->length && 9 === $cell2->length && 3 === $cell1e->length && 3 === $cell2e->length) {

        } elseif (0 === $cell1->length && 0 === $cell2->length && 3 === $cell1e->length && 3 === $cell2e->length) {

        } else {
            var_dump($cell1->length, $cell2->length, $cell1e->length, $cell2e->length);
            die('Wrong amount of cells. Html.id ' . array_get($dataArray, 'id'));
        }

        // main form must be first
        if ('' == $cell1e->item(0)->textContent) {
            $wordForms = [
                [
                    'word' => Word::cleanWord($cell1e->item(0)->textContent),
                    'number' => 'однина', 'kind' => 'родовий',
                    'isMainForm' => true
                ],[
                    'word' => $cell1e->item(1)->textContent,
                    'number' => 'однина', 'kind' => 'давальний',
                    'isMainForm' => false
                ],[
                    'word' => $cell2e->item(1)->textContent,
                    'number' => 'однина', 'kind' => 'знахідний',
                    'isMainForm' => false
                ],[
                    'word' => $cell1e->item(2)->textContent,
                    'number' => 'однина', 'kind' => 'орудний',
                    'isMainForm' => false
                ],[
                    'word' => Word::cleanWord($cell2e->item(2)->textContent),
                    'number' => 'однина', 'kind' => 'місцевий',
                    'isMainForm' => false
                ]
            ];
        } elseif ('' == $cell1->item(0)->textContent) {
            $wordForms = [
                [
                    'word' => $cell1e->item(0)->textContent,
                    'number' => 'однина', 'kind' => 'називний',
                    'isMainForm' => true
                ],[
                    'word' => $cell2e->item(0)->textContent,
                    'number' => 'однина', 'kind' => 'родовий',
                    'isMainForm' => false
                ],[
                    'word' => $cell1e->item(1)->textContent,
                    'number' => 'однина', 'kind' => 'давальний',
                    'isMainForm' => false
                ],[
                    'word' => $cell2e->item(1)->textContent,
                    'number' => 'однина', 'kind' => 'знахідний',
                    'isMainForm' => false
                ],[
                    'word' => $cell1e->item(2)->textContent,
                    'number' => 'однина', 'kind' => 'орудний',
                    'isMainForm' => false
                ],[
                    'word' => $cell2e->item(2)->textContent,
                    'number' => 'однина', 'kind' => 'місцевий',
                    'isMainForm' => false
                ]
            ];
        } else {
            $wordForms = [
                [
                    'word' => $cell1->item(0)->textContent,
                    'number' => 'однина', 'kind' => 'називний',
                    'genus' => 'чоловічий',
                    'isMainForm' => true,
                ],[
                    'word' => $cell1->item(1)->textContent,
                    'number' => 'однина', 'kind' => 'називний',
                    'genus' => 'жіночий',
                    'isMainForm' => false,
                ],[
                    'word' => $cell1->item(2)->textContent,
                    'number' => 'однина', 'kind' => 'називний',
                    'genus' => 'середній',
                    'isMainForm' => false,
                ],[
                    'word' => $cell1e->item(0)->textContent,
                    'number' => 'множина', 'kind' => 'називний',
                    'isMainForm' => false,
                ], [ // ***
                    'word' => $cell2->item(0)->textContent,
                    'number' => 'однина', 'kind' => 'родовий',
                    'genus' => 'чоловічий',
                    'isMainForm' => false,
                ],[
                    'word' => $cell2->item(1)->textContent,
                    'number' => 'однина', 'kind' => 'родовий',
                    'genus' => 'жіночий',
                    'isMainForm' => false,
                ],[
                    'word' => $cell2->item(2)->textContent,
                    'number' => 'однина', 'kind' => 'родовий',
                    'genus' => 'середній',
                    'isMainForm' => false,
                ],[
                    'word' => $cell2e->item(0)->textContent,
                    'number' => 'однина', 'kind' => 'родовий',
                    'isMainForm' => false,
                ],[ // ***
                    'word' => $cell1->item(3)->textContent,
                    'number' => 'однина', 'kind' => 'давальний',
                    'genus' => 'чоловічий',
                    'isMainForm' => false,
                ],[
                    'word' => $cell1->item(4)->textContent,
                    'number' => 'однина', 'kind' => 'давальний',
                    'genus' => 'жіночий',
                    'isMainForm' => false,
                ],[
                    'word' => $cell1->item(5)->textContent,
                    'number' => 'однина', 'kind' => 'давальний',
                    'genus' => 'середній',
                    'isMainForm' => false,
                ],[
                    'word' => $cell1e->item(1)->textContent,
                    'number' => 'множина', 'kind' => 'давальний',
                    'isMainForm' => false,
                ], [ // ***
                    'word' => $cell2->item(3)->textContent,
                    'number' => 'однина', 'kind' => 'знахідний',
                    'genus' => 'чоловічий',
                    'isMainForm' => false,
                ],[
                    'word' => $cell2->item(4)->textContent,
                    'number' => 'однина', 'kind' => 'знахідний',
                    'genus' => 'жіночий',
                    'isMainForm' => false,
                ],[
                    'word' => $cell2->item(5)->textContent,
                    'number' => 'однина', 'kind' => 'знахідний',
                    'genus' => 'середній',
                    'isMainForm' => false,
                ],[
                    'word' => $cell2e->item(1)->textContent,
                    'number' => 'однина', 'kind' => 'знахідний',
                    'isMainForm' => false,
                ],[ // ***
                    'word' => Word::cleanWord($cell1->item(6)->textContent),
                    'number' => 'однина', 'kind' => 'орудний',
                    'genus' => 'чоловічий',
                    'isMainForm' => false,
                ],[
                    'word' => Word::cleanWord($cell1->item(7)->textContent),
                    'number' => 'однина', 'kind' => 'орудний',
                    'genus' => 'жіночий',
                    'isMainForm' => false,
                ],[
                    'word' => Word::cleanWord($cell1->item(8)->textContent),
                    'number' => 'однина', 'kind' => 'орудний',
                    'genus' => 'середній',
                    'isMainForm' => false,
                ],[
                    'word' => Word::cleanWord($cell1e->item(2)->textContent),
                    'number' => 'множина', 'kind' => 'орудний',
                    'isMainForm' => false,
                ], [ // ***
                    'word' => Word::cleanWord($cell2->item(6)->textContent),
                    'number' => 'однина', 'kind' => 'місцевий',
                    'genus' => 'чоловічий',
                    'isMainForm' => false,
                ],[
                    'word' => Word::cleanWord($cell2->item(7)->textContent),
                    'number' => 'однина', 'kind' => 'місцевий',
                    'genus' => 'жіночий',
                    'isMainForm' => false,
                ],[
                    'word' => Word::cleanWord($cell2->item(8)->textContent),
                    'number' => 'однина', 'kind' => 'місцевий',
                    'genus' => 'середній',
                    'isMainForm' => false,
                ],[
                    'word' => Word::cleanWord($cell2e->item(2)->textContent),
                    'number' => 'однина', 'kind' => 'місцевий',
                    'isMainForm' => false,
                ],
            ];
        }

        $mainFormId = null;

        echo '[';
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
            $kind = $kind ? $kind : '-';
            $genus = $genus ? $genus : '-';

            if (0 < strpos($word, ',')) {
                $wordVariantsArr = explode(',', $word);
                foreach ($wordVariantsArr as $word) {
                    $word = trim($word);

                    $result = new SlovnykUaResults($dbh);
                    $result->firstOrNewTotal($word, $part_of_language, '-', $genus, $number, '-', $kind, '-',
                        '-', '-', '-', '-', '-', '-', 0, $is_main_form, '-', $dictionaryId);

                    if ($is_main_form) {
                        $mainFormId = $result->getId();
                    }

                    $result->updateProperty('main_form_code', PDO::PARAM_STR, $mainFormCodePrefix . $mainFormId);
                    $result->updateProperty('data_id', PDO::PARAM_INT, $dataId);
                }
            } else {
                $result = new SlovnykUaResults($dbh);
                $result->firstOrNewTotal($word, $part_of_language, '-', $genus, $number, '-', $kind, '-',
                    '-', '-', '-', '-', '-', '-', 0, $is_main_form, '-', $dictionaryId);

                if ($is_main_form) {
                    $mainFormId = $result->getId();
                }

                $result->updateProperty('main_form_code', PDO::PARAM_STR, $mainFormCodePrefix . $mainFormId);
                $result->updateProperty('data_id', PDO::PARAM_INT, $dataId);
            }

            $result = new SlovnykUaResults($dbh);
            $result->firstOrNewTotal($word, $part_of_language, '-', $genus, $number, '-', $kind, '-',
                '-', '-', '-', '-', '-', '-', 0, $is_main_form, '-', $dictionaryId);

            if ($is_main_form) {
                $mainFormId = $result->getId();
            }

            $result->updateProperty('main_form_code', PDO::PARAM_STR, $mainFormCodePrefix . $mainFormId);
            $result->updateProperty('data_id', PDO::PARAM_INT, $dataId);

            $data->updateProperty('is_in_results', PDO::PARAM_BOOL, true);
        }
        echo ']';

        $data->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
    }

    echo "\n";
}

$SlovnykUaDataC->backHtmlRowsToProcessing();

echo 'END';



