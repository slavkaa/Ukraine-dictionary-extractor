<?php

// @acton: php slovnyk_ua_handle_dieslovo.php

require_once('../support/_require_once.php');

// *** //
$dictionary = new Dictionary($dbh);
$dictionary->firstOrNew('slovnyk.ua', 'http://www.slovnyk.ua/?swrd=');
$dictionaryId = (int) $dictionary->getProperty('id');

$part_of_language = 'дієслово';

$htmlObj = new Html($dbh);
$counter = $htmlObj->countPartOfLanguage('%'.$part_of_language.'%', ' LIKE ');
$counter = intval($counter/100) + 1;
var_dump($counter);

echo "\n";

for ($j = 0; $j < $counter;  $j++) {
    $htmlObj = new Html($dbh);
    $allHtml = $htmlObj->getPartOfLanguage('%' . $part_of_language . '%', 100, 0, 'LIKE');

    echo $j . "00 \n";

    foreach ($allHtml as $htmlArray) {
        echo '<';

        $html = new Html($dbh);
        $html->getById(array_get($htmlArray, 'id'));

        $htmlData = new HtmlData($dbh);
        $htmlData->getByHtmlId(array_get($htmlArray, 'id'));

        // load extracted HTML=page
        $word = cleanCyrillic($htmlData->getProperty('word'));
        $text = cleanCyrillic($htmlData->getProperty('html_cut'));
        $text = str_replace(
            ['sfm_cell_1s', 'sfm_cell_2s', 'sfm_cell_1_x2', 'sfm_cell_1e_x2', 'sfm_cell_1e', 'sfm_cell_2_x2', 'sfm_cell_2e_x2', 'sfm_cell_2e'],
            ['sfm_cell_v',  'sfm_cell_v',  'sfm_cell_1',    'sfm_cell_e_1',   'sfm_cell_e_1',   'sfm_cell_2',    'sfm_cell_2e', 'sfm_cell_e_2'],
            $text);

        // filtrate $part_of_language {
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
                    $htmlCutPiece = $item->ownerDocument->saveHTML($item);
                    @$doc->loadHTML(mb_convert_encoding($htmlCutPiece, 'HTML-ENTITIES', 'UTF-8'));
                    $isFound = true;

                    echo '+';
                    break;
                }
            }

            if (!$isFound) {
                $html->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
                echo '-';
                continue;
            }
        // filtrate $part_of_language }

        // extract table
        $xpath = new DOMXpath($doc);
        /** @var DOMNodeList $partOfLanguageData */
        $definition = $xpath->query("//*[contains(@class, 'sfm_cell_hx')]");
        $definition = $definition->item(0)->textContent;
        $definition = explode(',', $definition);

        $infinitive = trim(str_replace(['дієслово', '-', ' '], '', array_get($definition, 0)));
        $verbKind = trim(array_get($definition, 1, '-'));
        $dievidmina = trim(array_get($definition, 2, '-'));

        $dievidmina = $dievidmina ? $dievidmina : '-';
        $verbKind = $verbKind ? $verbKind : '-';

        // standardisation {
        $verbKind = str_replace(' вид', '', $verbKind);

        if (-1 < strpos($dievidmina, 'ІІ дієвідміна')) {
            $dievidmina = '2 дієвідміна';
        } elseif (-1 < strpos($dievidmina, 'І дієвідміна')) {
            $dievidmina = '1 дієвідміна';
        } elseif ('-' === $dievidmina) {
            // OK
        } else {
            $dievidmina = null;
        }
        // standardisation }

        $cell2 = $xpath->query("//*[contains(@class, 'sfm_cell_2')]");
        $cell2e = $xpath->query("//*[contains(@class, 'sfm_cell_e_2')]");

        if (8 === $cell2->length && 8 === $cell2e->length) {
            // OK
        } elseif (11 === $cell2->length &&11 === $cell2e->length) {
            // OK
        } else {
            var_dump($cell2->length, $cell2e->length);
            die('Wrong amount of cells. Html.id ' . array_get($htmlArray, 'id'));
        }

        $infinitiveArr = [
            'word' => $infinitive,
            'verb_kind' => $verbKind ,
            'dievidmina' => $dievidmina,
        ];

        if (-1 < strpos($htmlCutPiece, 'теперешній')) { // є теперешній час
            // main form must be first
            $wordForms = [
                [
                    'word' => $cell2->item(0)->textContent,
                    'tense' => 'теперішній',
                    'number' => 'однина',
                    'person' => '1 особа',
                ],[
                    'word' => $cell2->item(1)->textContent,
                    'tense' => 'теперішній',
                    'number' => 'однина',
                    'person' => '2 особа',
                ],[
                    'word' => $cell2->item(2)->textContent,
                    'tense' => 'теперішній',
                    'number' => 'однина',
                    'person' => '3 особа',
                ],[
                    'word' => $cell2e->item(0)->textContent,
                    'tense' => 'теперішній',
                    'number' => 'множина',
                    'person' => '1 особа',
                ],[
                    'word' => $cell2e->item(1)->textContent,
                    'tense' => 'теперішній',
                    'number' => 'множина',
                    'person' => '2 особа',
                ],[
                    'word' => $cell2e->item(2)->textContent,
                    'tense' => 'теперішній',
                    'number' => 'множина',
                    'person' => '3 особа',
                ],[ // ***
                    'word' => $cell2->item(3)->textContent,
                    'tense' => 'майбутній',
                    'number' => 'однина',
                    'person' => '1 особа',
                ],[
                    'word' => $cell2->item(4)->textContent,
                    'tense' => 'майбутній',
                    'number' => 'однина',
                    'person' => '2 особа',
                ],[
                    'word' => $cell2->item(5)->textContent,
                    'tense' => 'майбутній',
                    'number' => 'однина',
                    'person' => '3 особа',
                ],[
                    'word' => $cell2e->item(3)->textContent,
                    'tense' => 'майбутній',
                    'number' => 'множина',
                    'person' => '1 особа',
                ],[
                    'word' => $cell2e->item(4)->textContent,
                    'tense' => 'майбутній',
                    'number' => 'множина',
                    'person' => '2 особа',
                ],[
                    'word' => $cell2e->item(5)->textContent,
                    'tense' => 'майбутній',
                    'number' => 'множина',
                    'person' => '3 особа',
                ],[ // ***
                    'word' => $cell2->item(6)->textContent,
                    'tense' => 'минулий',
                    'number' => 'однина',
                    'genus' => 'чоловічий',
                ],[
                    'word' => $cell2->item(7)->textContent,
                    'tense' => 'минулий',
                    'number' => 'однина',
                    'genus' => 'жіночий',
                ],[
                    'word' => $cell2->item(8)->textContent,
                    'tense' => 'минулий',
                    'number' => 'однина',
                    'genus' => 'середній',
                ],[
                    'word' => $cell2e->item(6)->textContent,
                    'tense' => 'минулий',
                    'number' => 'множина',
                    'person' => '1 особа',
                ],[
                    'word' => $cell2e->item(6)->textContent,
                    'tense' => 'минулий',
                    'number' => 'множина',
                    'person' => '2 особа',
                ],[
                    'word' => $cell2e->item(6)->textContent,
                    'tense' => 'минулий',
                    'number' => 'множина',
                    'person' => '3 особа',
                ],[ // ***
                    'word' => trim($cell2->item(9)->textContent),
                    'tense' => 'наказовий спосіб',
                    'number' => 'однина',
                    'person' => '1 особа',
                ],[
                    'word' => $cell2->item(10)->textContent,
                    'tense' => 'наказовий спосіб',
                    'number' => 'однина',
                    'person' => '2 особа',
                ],[
                    'word' => $cell2e->item(7)->textContent,
                    'tense' => 'наказовий спосіб',
                    'number' => 'множина',
                    'person' => '1 особа',
                ],[
                    'word' => $cell2e->item(8)->textContent,
                    'tense' => 'наказовий спосіб',
                    'number' => 'множина',
                    'person' => '2 особа',
                ]
            ];

            $diepruslivnyk = [
                [
                    'word' => trim($cell2e->item(9)->textContent),
                    'tense' => 'теперішній',
                ],[
                    'word' => trim($cell2e->item(10)->textContent),
                    'tense' => 'минулий',
                ]
            ];
        } else {  // нєма теперешнього часу
            // main form must be first
            $wordForms = [
                [ // ***
                    'word' => $cell2->item(0)->textContent,
                    'tense' => 'майбутній',
                    'number' => 'однина',
                    'person' => '1 особа',
                ],[
                    'word' => $cell2->item(1)->textContent,
                    'tense' => 'майбутній',
                    'number' => 'однина',
                    'person' => '2 особа',
                ],[
                    'word' => $cell2->item(2)->textContent,
                    'tense' => 'майбутній',
                    'number' => 'однина',
                    'person' => '3 особа',
                ],[
                    'word' => $cell2e->item(0)->textContent,
                    'tense' => 'майбутній',
                    'number' => 'множина',
                    'person' => '1 особа',
                ],[
                    'word' => $cell2e->item(1)->textContent,
                    'tense' => 'майбутній',
                    'number' => 'множина',
                    'person' => '2 особа',
                ],[
                    'word' => $cell2e->item(2)->textContent,
                    'tense' => 'майбутній',
                    'number' => 'множина',
                    'person' => '3 особа',
                ],[ // ***
                    'word' => $cell2->item(3)->textContent,
                    'tense' => 'минулий',
                    'number' => 'однина',
                    'genus' => 'чоловічий',
                ],[
                    'word' => $cell2->item(4)->textContent,
                    'tense' => 'минулий',
                    'number' => 'однина',
                    'genus' => 'жіночий',
                ],[
                    'word' => $cell2->item(5)->textContent,
                    'tense' => 'минулий',
                    'number' => 'однина',
                    'genus' => 'середній',
                ],[
                    'word' => $cell2e->item(3)->textContent,
                    'tense' => 'минулий',
                    'number' => 'множина',
                    'genus' => 'чоловічий',
                ],[
                    'word' => $cell2e->item(3)->textContent,
                    'tense' => 'минулий',
                    'number' => 'множина',
                    'genus' => 'жіночий',
                ],[
                    'word' => $cell2e->item(3)->textContent,
                    'tense' => 'минулий',
                    'number' => 'множина',
                    'genus' => 'середній',
                ],[ // ***
                    'word' => trim($cell2->item(6)->textContent),
                    'tense' => 'наказовий спосіб',
                    'number' => 'однина',
                    'person' => '1 особа',
                ],[
                    'word' => $cell2->item(7)->textContent,
                    'tense' => 'наказовий спосіб',
                    'number' => 'однина',
                    'person' => '2 особа',
                ],[
                    'word' => $cell2e->item(4)->textContent,
                    'tense' => 'наказовий спосіб',
                    'number' => 'множина',
                    'person' => '1 особа',
                ],[
                    'word' => $cell2e->item(5)->textContent,
                    'tense' => 'наказовий спосіб',
                    'number' => 'множина',
                    'person' => '2 особа',
                ]
            ];

            $diepruslivnyk = [
                [
                    'word' => trim($cell2e->item(6)->textContent),
                    'tense' => 'теперішній',
                ],[
                    'word' => trim($cell2e->item(7)->textContent),
                    'tense' => 'минулий',
                ]
            ];
        }

        $isInfinitive = ($infinitive === $word);

        // define infinitive {
        $mainFormId = null;
        if ( " " != $infinitive && !empty($infinitive)) {
            echo 'i';
            $htmlItem = new Html($dbh);
            $htmlItem->firstOrNewTotal($infinitive, 'дієслово', '-', '-', '-', '-', '-', $verbKind,
                $dievidmina, '-', '-', '-', '-', '-', 1, 1, '-', $dictionaryId);
            $mainFormId = $htmlItem->getId();

            $htmlItem->updateProperty('main_form_id', PDO::PARAM_INT, $mainFormId);
        }
        // define infinitive }

        foreach ($wordForms as $wordForm) {
            echo 'd';
            $word = trim(array_get($wordForm, 'word'));
            $tense = str_replace('', '', array_get($wordForm, 'tense', '-'));
            $number = array_get($wordForm, 'number', '-');
            $genus = array_get($wordForm, 'genus', '-');
            $person = array_get($wordForm, 'person', '-');

            $genus = $genus ? $genus : '-';
            $tense = $tense ? $tense : '-';
            $number = $number ? $number : '-';
            $person = $person ? $person : '-';

            if (" " == $word || " " == $word || empty($word)) {
                continue;
            }
            $htmlItem = new Html($dbh);
            $htmlItem->firstOrNewTotal($word, $part_of_language, '-', $genus, $number, $person, '-', $verbKind,
                $dievidmina, '-', '-', '-', $tense, '-', 0, 0, '-', $dictionaryId);
            $htmlItem->updateProperty('main_form_id', PDO::PARAM_INT, $mainFormId);
        }

        foreach ($diepruslivnyk as $wordForm) {
            echo 'p';
            $word = trim(array_get($wordForm, 'word'));
            $tense = array_get($wordForm, 'tense', '-');

            if (" " == $word ||' ' == $word || empty($word)) {
                continue;
            }

            $htmlItem->firstOrNewTotal(trim($word), 'дієприслівник', '-', '-', '-', '-', '-', '-',
                '-', '-', '-', '-', $tense, '-', 0, 0, '-', $dictionaryId);
            $htmlItem->updateProperty('main_form_id', PDO::PARAM_INT, $mainFormId);
        }

        $html->updateProperty('is_need_processing', PDO::PARAM_BOOL, false);
        echo '>';

//        die;
    }

    echo "\n";
}

$htmlObj->backHtmlRowsToProcessing();

echo 'END';



